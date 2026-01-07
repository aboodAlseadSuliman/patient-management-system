<?php

namespace App\Filament\Resources\HospitalConsultations\Pages;

use App\Filament\Resources\HospitalConsultations\HospitalConsultationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHospitalConsultations extends ListRecords
{
    protected static string $resource = HospitalConsultationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
