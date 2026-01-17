<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Exports\PatientExporter;
use App\Filament\Imports\PatientImporter;
use App\Filament\Resources\Patients\PatientResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListPatients extends ListRecords
{
    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('إضافة مريض'),
            \Filament\Actions\Action::make('download_latest_export')
                ->label('تحميل آخر تصدير')
                ->icon('heroicon-o-arrow-down-circle')
                ->color('success')
                ->action(function () {
                    $latestExport = \Filament\Actions\Exports\Models\Export::where('user_id', auth()->id())
                        ->where('exporter', \App\Filament\Exports\PatientExporter::class)
                        ->whereNotNull('completed_at')
                        ->latest()
                        ->first();

                    if ($latestExport) {
                        $filePath = storage_path('app/' . $latestExport->file_disk . '/filament_exports/' . $latestExport->id . '/' . $latestExport->file_name . '.xlsx');

                        if (file_exists($filePath)) {
                            return response()->download($filePath, 'المرضى-' . date('Y-m-d') . '.xlsx');
                        }
                    }

                    \Filament\Notifications\Notification::make()
                        ->title('لا يوجد ملف')
                        ->body('لم يتم العثور على ملف تصدير سابق')
                        ->warning()
                        ->send();
                })
                ->visible(fn () => \Filament\Actions\Exports\Models\Export::where('user_id', auth()->id())
                    ->where('exporter', \App\Filament\Exports\PatientExporter::class)
                    ->whereNotNull('completed_at')
                    ->exists()),
            ImportAction::make()
                ->label('استيراد')
                ->importer(PatientImporter::class)
                ->icon('heroicon-o-arrow-down-tray')
                ->color('info')
                ->maxRows(10000),
            ExportAction::make()
                ->label('تصدير')
                ->exporter(PatientExporter::class)
                ->icon('heroicon-o-arrow-up-tray')
                ->color('primary')
                ->fileName('المرضى-' . date('Y-m-d'))
                ->maxRows(10000),
        ];
    }
}
