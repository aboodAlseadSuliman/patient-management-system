<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPatients extends ListRecords
{
    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('إضافة مريض'),
            \Filament\Actions\Action::make('direct_export')
                ->label('تصدير Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    return \Maatwebsite\Excel\Facades\Excel::download(
                        new \App\Exports\PatientsExport(),
                        'المرضى-' . date('Y-m-d') . '.xlsx'
                    );
                }),
            \Filament\Actions\Action::make('import_old_records')
                ->label('استيراد سجلات قديمة')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('warning')
                ->fillForm(fn () => [])
                ->modalHeading('استيراد السجلات القديمة')
                ->modalDescription(new \Illuminate\Support\HtmlString(
                    'يدعم هذا الاستيراد الملفات بالتنسيق التالي:<br>' .
                    '<strong>التسلسل | الأسبوع | التاريخ | الاسم | التولد | الملف | السكن | الهاتف</strong><br>' .
                    '<small>يجب أن يكون السطر الأول عناوين الأعمدة.</small>'
                ))
                ->modalSubmitActionLabel('بدء الاستيراد')
                ->schema([
                    \Filament\Forms\Components\FileUpload::make('file')
                        ->label('ملف Excel')
                        ->disk('local')
                        ->directory('temp-imports')
                        ->visibility('private')
                        ->acceptedFileTypes([
                            'text/csv',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        ])
                        ->required()
                        ->helperText('رفع ملف XLSX أو XLS أو CSV'),
                ])
                ->action(function (array $data) {
                    try {
                        $disk = \Illuminate\Support\Facades\Storage::disk('local');
                        $filePath = $disk->path($data['file']);

                        if (!file_exists($filePath)) {
                            throw new \Exception('الملف غير موجود.');
                        }

                        // قراءة عدد الأوراق الفعلي في الملف
                        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
                        $sheetCount  = $spreadsheet->getSheetCount();
                        unset($spreadsheet); // تحرير الذاكرة

                        $import = new \App\Imports\PatientsOldRecordsImport($sheetCount);
                        \Maatwebsite\Excel\Facades\Excel::import($import, $filePath);

                        $disk->delete($data['file']);

                        \Filament\Notifications\Notification::make()
                            ->title('تم الاستيراد')
                            ->body("تم استيراد {$import->importedCount} سجل - تم تخطي {$import->skippedCount} سجل مكرر أو فارغ")
                            ->success()
                            ->duration(8000)
                            ->send();

                    } catch (\Exception $e) {
                        \Filament\Notifications\Notification::make()
                            ->title('خطأ في الاستيراد')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
