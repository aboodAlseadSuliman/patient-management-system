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
        if (isset($data['chronic_diseases_data']) && !empty($data['chronic_diseases_data'])) {
            $visit->patient->chronicDiseases()->syncWithoutDetaching(
                collect($data['chronic_diseases_data'])->mapWithKeys(function ($diseaseData) use ($visit) {
                    if (isset($diseaseData['chronic_disease_id'])) {
                        return [$diseaseData['chronic_disease_id'] => [
                            'diagnosis_date' => $diseaseData['diagnosis_date'] ?? $visit->visit_date,
                            'notes' => $diseaseData['notes'] ?? null,
                            'is_active' => true,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]];
                    }
                    return [];
                })->filter()->toArray()
            );
        }

        // ⭐ مزامنة الأدوية الدائمة مع ملف المريض
        if (isset($data['permanent_medications_data']) && !empty($data['permanent_medications_data'])) {
            $visit->patient->permanentMedications()->syncWithoutDetaching(
                collect($data['permanent_medications_data'])->mapWithKeys(function ($medicationData) {
                    if (isset($medicationData['medication_id'])) {
                        return [$medicationData['medication_id'] => [
                            'dosage' => $medicationData['dosage'] ?? null,
                            'frequency' => $medicationData['frequency'] ?? null,
                            'route' => $medicationData['route'] ?? 'oral',
                            'start_date' => $medicationData['start_date'] ?? now(),
                            'end_date' => $medicationData['end_date'] ?? null,
                            'notes' => $medicationData['notes'] ?? null,
                            'is_active' => true,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]];
                    }
                    return [];
                })->filter()->toArray()
            );
        }

        // حفظ الشكاية والأعراض
        if (isset($data['complaintSymptom']) && !empty(array_filter($data['complaintSymptom']))) {
            $visit->complaintSymptom()->create($data['complaintSymptom']);
        }

        // حفظ الشكاية المنظمة (النظام الجديد) - يتم حفظها في حقل JSON في جدول visits مباشرة
        // لا حاجة لحفظها هنا، Laravel يحفظها تلقائياً من خلال $fillable و $casts

        // حفظ الخط الزمني
        if (isset($data['timeline']) && !empty(array_filter($data['timeline']))) {
            $visit->timeline()->create($data['timeline']);
        }

        // حفظ المرفقات الطبية
        if (isset($data['medicalAttachment']) && !empty(array_filter($data['medicalAttachment']))) {
            $visit->medicalAttachment()->create($data['medicalAttachment']);
        }

        // حفظ ملفات المرفقات الطبية المرفوعة
        if (isset($data['attachment_files_data']) && !empty($data['attachment_files_data'])) {
            foreach ($data['attachment_files_data'] as $attachmentData) {
                if (isset($attachmentData['file_path']) && $attachmentData['file_path']) {
                    // استخراج معلومات الملف
                    $filePath = $attachmentData['file_path'];
                    $fullPath = public_path('medical-attachments/' . $filePath);

                    $visit->attachmentFiles()->create([
                        'attachment_type' => $attachmentData['attachment_type'],
                        'file_path' => $filePath, // حفظ المسار النسبي فقط (disk يضيف البادئة تلقائياً)
                        'original_filename' => basename($filePath),
                        'mime_type' => file_exists($fullPath) ? mime_content_type($fullPath) : null,
                        'file_size' => file_exists($fullPath) ? filesize($fullPath) : null,
                        'notes' => $attachmentData['notes'] ?? null,
                        'uploaded_by' => auth()->id(),
                    ]);
                }
            }
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

        // ==================== حفظ الأدوية ====================
        if (isset($data['medicationsData']) && !empty($data['medicationsData'])) {
            \Log::info('CreateVisit - Starting medications sync');
            $syncData = [];

            foreach ($data['medicationsData'] as $medicationData) {
                \Log::info('CreateVisit - Processing medication:', ['medicationData' => $medicationData]);
                if (isset($medicationData['medication_id'])) {
                    $syncData[$medicationData['medication_id']] = [
                        'dosage' => $medicationData['dosage'] ?? null,
                        'frequency' => $medicationData['frequency'] ?? null,
                        'duration' => $medicationData['duration'] ?? null,
                        'instructions' => $medicationData['instructions'] ?? null,
                        'notes' => $medicationData['notes'] ?? null,
                    ];
                }
            }
            \Log::info('CreateVisit - Medications sync data prepared:', ['syncData' => $syncData]);
            $visit->medications()->sync($syncData);
            \Log::info('CreateVisit - Medications sync completed');

            // التحقق من الحفظ
            $savedCount = $visit->medications()->count();
            \Log::info('CreateVisit - Medications saved count:', ['count' => $savedCount]);
        } else {
            \Log::warning('CreateVisit - medicationsData is empty or not set');
        }

        // ==================== حفظ الأشعة المطلوبة ====================
        if (isset($data['imagingStudiesData']) && !empty($data['imagingStudiesData'])) {
            \Log::info('CreateVisit - Starting imaging studies sync');
            $syncData = [];

            foreach ($data['imagingStudiesData'] as $imagingData) {
                \Log::info('CreateVisit - Processing imaging study:', ['imagingData' => $imagingData]);
                if (isset($imagingData['imaging_study_id'])) {
                    $syncData[$imagingData['imaging_study_id']] = [
                        'notes' => $imagingData['notes'] ?? null,
                        'findings' => null,
                        'impression' => null,
                        'study_date' => null,
                    ];
                }
            }
            \Log::info('CreateVisit - Imaging studies sync data prepared:', ['syncData' => $syncData]);
            $visit->imagingStudies()->sync($syncData);
            \Log::info('CreateVisit - Imaging studies sync completed');

            // التحقق من الحفظ
            $savedCount = $visit->imagingStudies()->count();
            \Log::info('CreateVisit - Imaging studies saved count:', ['count' => $savedCount]);
        } else {
            \Log::warning('CreateVisit - imagingStudiesData is empty or not set');
        }
    }
}
