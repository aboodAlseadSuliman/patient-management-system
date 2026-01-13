<?php

namespace App\Filament\Resources\Visits\Pages;

use App\Filament\Resources\Visits\VisitResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditVisit extends EditRecord
{
    protected static string $resource = VisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    /**
     * تحميل جميع العلاقات عند فتح صفحة التعديل
     */
    protected function resolveRecord(int | string $key): \Illuminate\Database\Eloquent\Model
    {
        return parent::resolveRecord($key)->load([
            'patient',
            'referringDoctor',
            'complaintSymptom',
            'timeline',
            'medicalAttachment',
            'clinicalExamination',
            'treatmentPlan',
            'followup',
            'labTests',
            'preliminaryDiagnoses',
            'attachmentFiles',
        ]);
    }

    /**
     * تحميل البيانات من الجداول المرتبطة عند تحرير الزيارة
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $visit = $this->record;

        // تحميل بيانات الشكاية والأعراض
        if ($visit->complaintSymptom) {
            $data['complaintSymptom'] = $visit->complaintSymptom->toArray();
        }

        // تحميل بيانات الخط الزمني
        if ($visit->timeline) {
            $data['timeline'] = $visit->timeline->toArray();
        }

        // تحميل بيانات المرفقات الطبية
        if ($visit->medicalAttachment) {
            $data['medicalAttachment'] = $visit->medicalAttachment->toArray();
        }

        // تحميل بيانات الفحص السريري
        if ($visit->clinicalExamination) {
            $data['clinicalExamination'] = $visit->clinicalExamination->toArray();
        }

        // تحميل بيانات خطة العلاج
        if ($visit->treatmentPlan) {
            $data['treatmentPlan'] = $visit->treatmentPlan->toArray();
        }

        // تحميل بيانات المتابعة
        if ($visit->followup) {
            $data['followup'] = $visit->followup->toArray();
        }

        // تحميل بيانات ملفات المرفقات الطبية المرفوعة
        if ($visit->attachmentFiles->isNotEmpty()) {
            $data['attachment_files_data'] = $visit->attachmentFiles->map(function ($file) {
                // إزالة البادئة medical-attachments/ لأن الـ disk يضيفها تلقائياً
                $filePath = str_replace('medical-attachments/', '', $file->file_path);

                return [
                    'id' => $file->id,
                    'attachment_type' => $file->attachment_type,
                    'file_path' => $filePath,
                    'notes' => $file->notes,
                ];
            })->toArray();
        }

        return $data;
    }

    /**
     * حفظ/تحديث البيانات في الجداول المرتبطة بعد تحديث الزيارة
     */
    protected function afterSave(): void
    {
        $data = $this->form->getState();
        $visit = $this->record;

        // ⭐ مزامنة الأمراض المزمنة مع ملف المريض
        if (isset($data['chronic_diseases_data'])) {
            $visit->patient->chronicDiseases()->sync(
                collect($data['chronic_diseases_data'])->mapWithKeys(function ($diseaseData) use ($visit) {
                    if (isset($diseaseData['chronic_disease_id'])) {
                        return [$diseaseData['chronic_disease_id'] => [
                            'diagnosis_date' => $diseaseData['diagnosis_date'] ?? $visit->visit_date,
                            'notes' => $diseaseData['notes'] ?? null,
                            'is_active' => true,
                            'updated_at' => now(),
                        ]];
                    }
                    return [];
                })->filter()->toArray()
            );
        }

        // ⭐ مزامنة الأدوية الدائمة مع ملف المريض
        if (isset($data['permanent_medications_data'])) {
            $visit->patient->permanentMedications()->sync(
                collect($data['permanent_medications_data'])->mapWithKeys(function ($medicationData) use ($visit) {
                    if (isset($medicationData['medication_id'])) {
                        return [$medicationData['medication_id'] => [
                            'dosage' => $medicationData['dosage'] ?? null,
                            'frequency' => $medicationData['frequency'] ?? null,
                            'route' => $medicationData['route'] ?? 'oral',
                            'start_date' => $medicationData['start_date'] ?? now(),
                            'end_date' => $medicationData['end_date'] ?? null,
                            'notes' => $medicationData['notes'] ?? null,
                            'is_active' => true,
                            'updated_at' => now(),
                        ]];
                    }
                    return [];
                })->filter()->toArray()
            );
        }

        // تحديث أو إنشاء الشكاية والأعراض
        if (isset($data['complaintSymptom'])) {
            $visit->complaintSymptom()->updateOrCreate(
                ['visit_id' => $visit->id],
                $data['complaintSymptom']
            );
        }

        // تحديث أو إنشاء الخط الزمني
        if (isset($data['timeline'])) {
            $visit->timeline()->updateOrCreate(
                ['visit_id' => $visit->id],
                $data['timeline']
            );
        }

        // تحديث أو إنشاء المرفقات الطبية
        if (isset($data['medicalAttachment'])) {
            $visit->medicalAttachment()->updateOrCreate(
                ['visit_id' => $visit->id],
                $data['medicalAttachment']
            );
        }

        // حفظ/تحديث ملفات المرفقات الطبية المرفوعة
        if (isset($data['attachment_files_data'])) {
            // الحصول على معرفات المرفقات الموجودة في النموذج
            $existingIds = collect($data['attachment_files_data'])
                ->pluck('id')
                ->filter()
                ->toArray();

            // حذف المرفقات التي تم إزالتها من النموذج
            $visit->attachmentFiles()
                ->whereNotIn('id', $existingIds)
                ->get()
                ->each(function ($attachment) {
                    $attachment->delete(); // سيتم حذف الملف تلقائياً من boot method
                });

            // إضافة أو تحديث المرفقات
            foreach ($data['attachment_files_data'] as $attachmentData) {
                if (isset($attachmentData['file_path']) && $attachmentData['file_path']) {
                    $filePath = $attachmentData['file_path'];
                    // الحصول على المسار الكامل للتحقق من الملف
                    $fullPath = public_path('medical-attachments/' . $filePath);

                    if (isset($attachmentData['id']) && $attachmentData['id']) {
                        // تحديث مرفق موجود
                        $existingAttachment = $visit->attachmentFiles()->find($attachmentData['id']);

                        if ($existingAttachment) {
                            // التحقق إذا تم تغيير الملف
                            if ($existingAttachment->file_path !== $filePath) {
                                // حذف الملف القديم
                                $oldFullPath = public_path('medical-attachments/' . $existingAttachment->file_path);
                                if (file_exists($oldFullPath)) {
                                    unlink($oldFullPath);
                                }

                                // تحديث بمعلومات الملف الجديد
                                $existingAttachment->update([
                                    'attachment_type' => $attachmentData['attachment_type'],
                                    'file_path' => $filePath, // حفظ المسار النسبي فقط
                                    'original_filename' => basename($filePath),
                                    'mime_type' => file_exists($fullPath) ? mime_content_type($fullPath) : null,
                                    'file_size' => file_exists($fullPath) ? filesize($fullPath) : null,
                                    'notes' => $attachmentData['notes'] ?? null,
                                ]);
                            } else {
                                // تحديث فقط النوع والملاحظات (الملف لم يتغير)
                                $existingAttachment->update([
                                    'attachment_type' => $attachmentData['attachment_type'],
                                    'notes' => $attachmentData['notes'] ?? null,
                                ]);
                            }
                        }
                    } else {
                        // إنشاء مرفق جديد
                        $visit->attachmentFiles()->create([
                            'attachment_type' => $attachmentData['attachment_type'],
                            'file_path' => $filePath, // حفظ المسار النسبي فقط
                            'original_filename' => basename($filePath),
                            'mime_type' => file_exists($fullPath) ? mime_content_type($fullPath) : null,
                            'file_size' => file_exists($fullPath) ? filesize($fullPath) : null,
                            'notes' => $attachmentData['notes'] ?? null,
                            'uploaded_by' => auth()->id(),
                        ]);
                    }
                }
            }
        }

        // تحديث أو إنشاء الفحص السريري
        if (isset($data['clinicalExamination'])) {
            $visit->clinicalExamination()->updateOrCreate(
                ['visit_id' => $visit->id],
                $data['clinicalExamination']
            );
        }

        // إضافة حقول التحاليل إلى treatmentPlan
        if (!isset($data['treatmentPlan'])) {
            $data['treatmentPlan'] = [];
        }
        $data['treatmentPlan']['lab_tests_input_method'] = $data['lab_tests_input_method'] ?? 'detailed';
        $data['treatmentPlan']['lab_tests_simple_notes'] = $data['labTestsSimpleNotes'] ?? null;

        // تحديث أو إنشاء خطة العلاج
        if (isset($data['treatmentPlan'])) {
            $visit->treatmentPlan()->updateOrCreate(
                ['visit_id' => $visit->id],
                $data['treatmentPlan']
            );
        }

        // تحديث أو إنشاء المتابعة
        if (isset($data['followup'])) {
            $visit->followup()->updateOrCreate(
                ['visit_id' => $visit->id],
                $data['followup']
            );
        }

        // حفظ التحاليل المطلوبة
        $labTestsInputMethod = $data['lab_tests_input_method'] ?? 'detailed';

        if ($labTestsInputMethod === 'detailed' && isset($data['labTestsData'])) {
            // الطريقة التفصيلية (Repeater)
            \Log::info('EditVisit - Starting lab tests sync (detailed method)');
            $syncData = [];
            foreach ($data['labTestsData'] as $labTestData) {
                if (isset($labTestData['lab_test_id'])) {
                    $syncData[$labTestData['lab_test_id']] = [
                        'notes' => $labTestData['notes'] ?? null,
                        'result' => null,
                        'test_date' => null,
                        'is_normal' => null,
                    ];
                }
            }
            \Log::info('EditVisit - Sync data prepared:', ['syncData' => $syncData]);
            $visit->labTests()->sync($syncData);
            \Log::info('EditVisit - Sync completed');
        } elseif ($labTestsInputMethod === 'simple' && isset($data['labTestsSimple'])) {
            // الطريقة البسيطة (Select متعدد)
            \Log::info('EditVisit - Starting lab tests sync (simple method)');
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

            \Log::info('EditVisit - Sync data prepared:', ['syncData' => $syncData]);
            $visit->labTests()->sync($syncData);
            \Log::info('EditVisit - Sync completed');

            $savedCount = $visit->labTests()->count();
            \Log::info('EditVisit - Lab tests saved count:', ['count' => $savedCount]);
        } else {
            \Log::warning('EditVisit - labTestsData is empty or not set');
        }

        // ==================== حفظ الأدوية ====================
        if (isset($data['medicationsData']) && !empty($data['medicationsData'])) {
            \Log::info('EditVisit - Starting medications sync');
            $syncData = [];

            foreach ($data['medicationsData'] as $medicationData) {
                \Log::info('EditVisit - Processing medication:', ['medicationData' => $medicationData]);
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
            \Log::info('EditVisit - Medications sync data prepared:', ['syncData' => $syncData]);
            $visit->medications()->sync($syncData);
            \Log::info('EditVisit - Medications sync completed');

            // التحقق من الحفظ
            $savedCount = $visit->medications()->count();
            \Log::info('EditVisit - Medications saved count:', ['count' => $savedCount]);
        } else {
            \Log::warning('EditVisit - medicationsData is empty or not set');
        }

        // ==================== حفظ الأشعة المطلوبة ====================
        if (isset($data['imagingStudiesData']) && !empty($data['imagingStudiesData'])) {
            \Log::info('EditVisit - Starting imaging studies sync');
            $syncData = [];

            foreach ($data['imagingStudiesData'] as $imagingData) {
                \Log::info('EditVisit - Processing imaging study:', ['imagingData' => $imagingData]);
                if (isset($imagingData['imaging_study_id'])) {
                    $syncData[$imagingData['imaging_study_id']] = [
                        'notes' => $imagingData['notes'] ?? null,
                        'findings' => null,
                        'impression' => null,
                        'study_date' => null,
                    ];
                }
            }
            \Log::info('EditVisit - Imaging studies sync data prepared:', ['syncData' => $syncData]);
            $visit->imagingStudies()->sync($syncData);
            \Log::info('EditVisit - Imaging studies sync completed');

            // التحقق من الحفظ
            $savedCount = $visit->imagingStudies()->count();
            \Log::info('EditVisit - Imaging studies saved count:', ['count' => $savedCount]);
        } else {
            \Log::warning('EditVisit - imagingStudiesData is empty or not set');
        }
    }
}
