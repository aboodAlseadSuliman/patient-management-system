<?php

namespace App\Filament\Resources\ImagingStudies\Pages;

use App\Filament\Resources\ImagingStudies\ImagingStudyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageImagingStudies extends ManageRecords
{
    protected static string $resource = ImagingStudyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
