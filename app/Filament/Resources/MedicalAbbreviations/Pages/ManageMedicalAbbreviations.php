<?php

namespace App\Filament\Resources\MedicalAbbreviations\Pages;

use App\Filament\Resources\MedicalAbbreviations\MedicalAbbreviationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageMedicalAbbreviations extends ManageRecords
{
    protected static string $resource = MedicalAbbreviationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
