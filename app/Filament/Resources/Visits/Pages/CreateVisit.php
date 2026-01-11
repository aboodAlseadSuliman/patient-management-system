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

        // 🔍 تتبع بيانات التحاليل للتصحيح
        \Log::info('CreateVisit - Full Form Data:', ['data' => $data]);
        \Log::info('CreateVisit - labTestsData exists:', ['exists' => isset($data['labTestsData'])]);
        if (isset($data['labTestsData'])) {
            \Log::info('CreateVisit - labTestsData content:', ['labTestsData' => $data['labTestsData']]);
        }

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

        // إضافة حقول التحاليل إلى treatmentPlan
        if (!isset($data['treatmentPlan'])) {
            $data['treatmentPlan'] = [];
        }
        $data['treatmentPlan']['lab_tests_input_method'] = $data['lab_tests_input_method'] ?? 'detailed';
        $data['treatmentPlan']['lab_tests_simple_notes'] = $data['labTestsSimpleNotes'] ?? null;

        // حفظ خطة العلاج
        if (isset($data['treatmentPlan']) && !empty(array_filter($data['treatmentPlan']))) {
            $visit->treatmentPlan()->create($data['treatmentPlan']);
        }

        // حفظ المتابعة
        if (isset($data['followup']) && !empty(array_filter($data['followup']))) {
            $visit->followup()->create($data['followup']);
        }

        // حفظ التحاليل المطلوبة
        $labTestsInputMethod = $data['lab_tests_input_method'] ?? 'detailed';

        if ($labTestsInputMethod === 'detailed' && isset($data['labTestsData']) && !empty($data['labTestsData'])) {
            // الطريقة التفصيلية (Repeater)
            \Log::info('CreateVisit - Starting lab tests sync (detailed method)');
            $syncData = [];
            foreach ($data['labTestsData'] as $labTestData) {
                \Log::info('CreateVisit - Processing lab test:', ['labTestData' => $labTestData]);
                if (isset($labTestData['lab_test_id'])) {
                    $syncData[$labTestData['lab_test_id']] = [
                        'notes' => $labTestData['notes'] ?? null,
                        'result' => null,
                        'test_date' => null,
                        'is_normal' => null,
                    ];
                }
            }
            \Log::info('CreateVisit - Sync data prepared:', ['syncData' => $syncData]);
            $visit->labTests()->sync($syncData);
            \Log::info('CreateVisit - Sync completed');

            // التحقق من الحفظ
            $savedCount = $visit->labTests()->count();
            \Log::info('CreateVisit - Lab tests saved count:', ['count' => $savedCount]);
        } elseif ($labTestsInputMethod === 'simple' && isset($data['labTestsSimple']) && !empty($data['labTestsSimple'])) {
            // الطريقة البسيطة (Select متعدد)
            \Log::info('CreateVisit - Starting lab tests sync (simple method)');
            $syncData = [];
            $generalNotes = $data['labTestsSimpleNotes'] ?? null;

            foreach ($data['labTestsSimple'] as $labTestId) {
                $syncData[$labTestId] = [
                    'notes' => $generalNotes,
                    'result' => null,
                    'test_date' => null,
                    'is_normal' => null,
                ];
            }

            \Log::info('CreateVisit - Sync data prepared:', ['syncData' => $syncData]);
            $visit->labTests()->sync($syncData);
            \Log::info('CreateVisit - Sync completed');

            // التحقق من الحفظ
            $savedCount = $visit->labTests()->count();
            \Log::info('CreateVisit - Lab tests saved count:', ['count' => $savedCount]);
        } else {
            \Log::warning('CreateVisit - labTestsData is empty or not set');
        }
    }
}
