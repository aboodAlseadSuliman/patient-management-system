<?php

namespace App\Filament\Resources\HospitalConsultations\Pages;

use App\Filament\Resources\HospitalConsultations\HospitalConsultationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHospitalConsultation extends CreateRecord
{
    protected static string $resource = HospitalConsultationResource::class;

    public function getTitle(): string
    {
        return 'معاينة مشفى جديدة';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'تم إنشاء معاينة المشفى بنجاح';
    }
}
