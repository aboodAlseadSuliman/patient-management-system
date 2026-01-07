<?php

namespace App\Filament\Resources\HospitalConsultations\Pages;

use App\Filament\Resources\HospitalConsultations\HospitalConsultationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewHospitalConsultation extends ViewRecord
{
    protected static string $resource = HospitalConsultationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('تعديل'),
        ];
    }

    public function getTitle(): string
    {
        return 'عرض معاينة المشفى';
    }
}
