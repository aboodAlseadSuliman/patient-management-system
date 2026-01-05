<?php

namespace App\Filament\Resources\Visits\Pages;

use App\Filament\Resources\Visits\VisitResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateVisit extends CreateRecord
{
    protected static string $resource = VisitResource::class;

    /**
     * حفظ البيانات في الجداول المرتبطة بعد إنشاء الزيارة
     */
    protected function afterCreate(): void
    {
        $data = $this->form->getState();
        $visit = $this->record;

        // حفظ الشكاية والأعراض
        if (isset($data['complaintSymptom']) && !empty(array_filter($data['complaintSymptom']))) {
            $visit->complaintSymptom()->create($data['complaintSymptom']);
        }

        // حفظ الخط الزمني
        if (isset($data['timeline']) && !empty(array_filter($data['timeline']))) {
            $visit->timeline()->create($data['timeline']);
        }

        // حفظ المرفقات الطبية
        if (isset($data['medicalAttachment']) && !empty(array_filter($data['medicalAttachment']))) {
            $visit->medicalAttachment()->create($data['medicalAttachment']);
        }

        // حفظ الفحص السريري
        if (isset($data['clinicalExamination']) && !empty(array_filter($data['clinicalExamination']))) {
            $visit->clinicalExamination()->create($data['clinicalExamination']);
        }

        // حفظ خطة العلاج
        if (isset($data['treatmentPlan']) && !empty(array_filter($data['treatmentPlan']))) {
            $visit->treatmentPlan()->create($data['treatmentPlan']);
        }

        // حفظ المتابعة
        if (isset($data['followup']) && !empty(array_filter($data['followup']))) {
            $visit->followup()->create($data['followup']);
        }
    }
}
