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
            ImportAction::make()
                ->label('استيراد')
                ->importer(PatientImporter::class)
                ->icon('heroicon-o-arrow-up-tray')
                ->color('info')
                ->maxRows(10000),
        ];
    }
}
