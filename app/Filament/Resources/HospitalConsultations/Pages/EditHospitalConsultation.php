<?php

namespace App\Filament\Resources\HospitalConsultations\Pages;

use App\Filament\Resources\HospitalConsultations\HospitalConsultationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditHospitalConsultation extends EditRecord
{
    protected static string $resource = HospitalConsultationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->label('عرض'),
            DeleteAction::make()
                ->label('حذف'),
            ForceDeleteAction::make()
                ->label('حذف نهائي'),
            RestoreAction::make()
                ->label('استعادة'),
        ];
    }

    public function getTitle(): string
    {
        return 'تعديل معاينة المشفى';
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'تم حفظ التغييرات بنجاح';
    }
}
