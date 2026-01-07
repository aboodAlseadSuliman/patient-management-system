<?php

namespace App\Filament\Resources\EndoscopyProcedures\Pages;

use App\Filament\Resources\EndoscopyProcedures\EndoscopyProcedureResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEndoscopyProcedure extends CreateRecord
{
    protected static string $resource = EndoscopyProcedureResource::class;

    public function getTitle(): string
    {
        return 'إجراء تنظير جديد';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'تم إنشاء إجراء التنظير بنجاح';
    }
}
