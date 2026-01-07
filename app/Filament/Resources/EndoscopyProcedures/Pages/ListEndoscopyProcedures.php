<?php

namespace App\Filament\Resources\EndoscopyProcedures\Pages;

use App\Filament\Resources\EndoscopyProcedures\EndoscopyProcedureResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEndoscopyProcedures extends ListRecords
{
    protected static string $resource = EndoscopyProcedureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('إجراء جديد'),
        ];
    }

    public function getTitle(): string
    {
        return 'إجراءات التنظير';
    }
}
