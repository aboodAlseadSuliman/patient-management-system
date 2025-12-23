<?php

namespace App\Filament\Resources\LabTests\Pages;

use App\Filament\Resources\LabTests\LabTestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageLabTests extends ManageRecords
{
    protected static string $resource = LabTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
