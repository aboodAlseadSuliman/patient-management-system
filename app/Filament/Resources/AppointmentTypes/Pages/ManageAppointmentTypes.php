<?php

namespace App\Filament\Resources\AppointmentTypes\Pages;

use App\Filament\Resources\AppointmentTypes\AppointmentTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageAppointmentTypes extends ManageRecords
{
    protected static string $resource = AppointmentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
