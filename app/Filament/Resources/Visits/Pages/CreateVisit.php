<?php

namespace App\Filament\Resources\Visits\Pages;

use App\Filament\Resources\Visits\VisitResource;
use Filament\Resources\Pages\CreateRecord;

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

        // ⭐ مزامنة الأمراض المزمنة مع ملف المريض
        if (isset($data['chronic_diseases_sync']) && !empty($data['chronic_diseases_sync'])) {
            $visit->patient->chronicDiseases()->syncWithoutDetaching(
                collect($data['chronic_diseases_sync'])->mapWithKeys(function ($diseaseId) use ($visit) {
                    return [$diseaseId => [
                        'diagnosis_date' => $visit->visit_date,
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]];
                })->toArray()
            );
        }

        // ⭐ مزامنة الأدوية الدائمة مع ملف المريض
        if (isset($data['permanent_medications_sync']) && !empty($data['permanent_medications_sync'])) {
            $visit->patient->permanentMedications()->syncWithoutDetaching(
                collect($data['permanent_medications_sync'])->mapWithKeys(function ($medicationId) {
                    return [$medicationId => [
                        'is_active' => true,
                        'start_date' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]];
                })->toArray()
            );
        }

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
