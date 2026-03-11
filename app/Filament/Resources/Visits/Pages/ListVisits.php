<?php

namespace App\Filament\Resources\Visits\Pages;

use App\Filament\Resources\Visits\VisitResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListVisits extends ListRecords
{
    protected static string $resource = VisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    /**
     * تحميل العلاقات المطلوبة مع الجدول لتحسين الأداء
     */
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->with([
                'patient',
                'followup',
                'creator',
                'updater',
            ]);
    }
}
