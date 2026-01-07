<?php

namespace App\Filament\Resources\EndoscopyProcedures\Pages;

use App\Filament\Resources\EndoscopyProcedures\EndoscopyProcedureResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditEndoscopyProcedure extends EditRecord
{
    protected static string $resource = EndoscopyProcedureResource::class;

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
        return 'تعديل إجراء التنظير';
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'تم حفظ التغييرات بنجاح';
    }
}
