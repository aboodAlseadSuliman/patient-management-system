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
            \Filament\Actions\Action::make('direct_import')
                ->label('استيراد Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('info')
                ->fillForm(fn () => [])
                ->modalHeading('استيراد ملف المرضى')
                ->modalDescription('اختر ملف Excel أو CSV لاستيراد بيانات المرضى')
                ->modalSubmitActionLabel('استيراد')
                ->schema([
                    \Filament\Forms\Components\FileUpload::make('file')
                        ->label('ملف الاستيراد')
                        ->disk('local')
                        ->directory('temp-imports')
                        ->visibility('private')
                        ->acceptedFileTypes([
                            'text/csv',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        ])
                        ->required()
                        ->helperText('يمكنك رفع ملفات CSV أو Excel (XLSX/XLS)'),
                ])
                ->action(function (array $data) {
                    try {
                        // استخدام Storage facade للوصول إلى الملف
                        $disk = \Illuminate\Support\Facades\Storage::disk('local');
                        $filePath = $disk->path($data['file']);

                        // التحقق من وجود الملف
                        if (!file_exists($filePath)) {
                            throw new \Exception('الملف غير موجود في المسار: ' . $filePath);
                        }

                        $import = new \App\Imports\PatientsImport();
                        \Maatwebsite\Excel\Facades\Excel::import($import, $filePath);

                        // حذف الملف المؤقت
                        $disk->delete($data['file']);

                        \Filament\Notifications\Notification::make()
                            ->title('تم الاستيراد بنجاح')
                            ->body('تم استيراد بيانات المرضى بنجاح')
                            ->success()
                            ->send();

                    } catch (\Exception $e) {
                        \Filament\Notifications\Notification::make()
                            ->title('فشل الاستيراد')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
