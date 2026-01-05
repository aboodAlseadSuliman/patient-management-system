<?php

namespace App\Filament\Resources\Visits\Pages;

use App\Filament\Resources\Visits\VisitResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;

class ViewVisit extends ViewRecord
{
    protected static string $resource = VisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    /**
     * تحميل جميع العلاقات المطلوبة لعرض الزيارة
     */
    protected function resolveRecord(int | string $key): Model
    {
        return static::getResource()::resolveRecordRouteBinding($key)
            ->load([
                'patient',
                'referringDoctor',
                'creator',
                'complaintSymptom',
                'timeline',
                'medicalAttachment',
                'clinicalExamination',
                'treatmentPlan',
                'followup',
            ]);
    }
}
