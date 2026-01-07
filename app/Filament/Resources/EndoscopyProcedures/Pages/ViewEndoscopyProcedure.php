<?php

namespace App\Filament\Resources\EndoscopyProcedures\Pages;

use App\Filament\Resources\EndoscopyProcedures\EndoscopyProcedureResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEndoscopyProcedure extends ViewRecord
{
    protected static string $resource = EndoscopyProcedureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('تعديل'),
        ];
    }

    public function getTitle(): string
    {
        return 'عرض إجراء التنظير';
    }
}
