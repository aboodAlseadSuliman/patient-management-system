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
            'clinicalExamination',
            'treatmentPlan',
            'followup',
            'labTests',
            'preliminaryDiagnoses',
            'attachmentFiles',
            'labTestResults.labTest',
            'labTestResults.attachmentFile',
            'pathologyRequests',
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

        // تحميل بيانات ملفات المرفقات الطبية المرفوعة (استبعاد صور التحاليل)
        $generalAttachments = $visit->attachmentFiles()->whereDoesntHave('labTestResults')->get();
        if ($generalAttachments->isNotEmpty()) {
            $data['attachment_files_data'] = $generalAttachments->map(function ($file) {
                // إزالة البادئة medical-attachments/ لأن الـ disk يضيفها تلقائياً
                $filePath = str_replace('medical-attachments/', '', $file->file_path);

                return [
                    'id' => $file->id,
                    'attachment_type_id' => $file->attachment_type_id,
                    'attachment_type' => $file->attachment_type, // للتوافق مع البيانات القديمة
                    'attachment_name' => $file->attachment_name,
                    'file_path' => $filePath,
                    'notes' => $file->notes,
                ];
            })->toArray();
        }

        // تحميل بيانات نتائج التحاليل
        if ($visit->labTestResults->isNotEmpty()) {
            $data['lab_test_results_data'] = $visit->labTestResults->map(function ($result) {
                $labImagePath = null;
                if ($result->attachmentFile) {
                    // إزالة البادئة medical-attachments/ لأن الـ disk يضيفها تلقائياً
                    $labImagePath = str_replace('medical-attachments/', '', $result->attachmentFile->file_path);
                }

                return [
                    'id' => $result->id,
                    'lab_test_id' => $result->lab_test_id,
                    'attachment_file_id' => $result->attachment_file_id,
                    'lab_image_path' => $labImagePath,
                    'test_date' => $result->test_date,
                    'result_value' => $result->result_value,
                    'reference_range' => $result->reference_range,
                    'unit' => $result->unit,
                    'is_normal' => $result->is_normal,
                    'previous_value' => $result->previous_value,
                    'previous_test_date' => $result->previous_test_date,
                    'notes' => $result->notes,
                ];
            })->toArray();
        }

        // تحميل بيانات طلبات التشريح المرضي
        if ($visit->pathologyRequests->isNotEmpty()) {
            $data['pathologyRequestsData'] = $visit->pathologyRequests->map(function ($request) {
                return [
                    'id' => $request->id,
                    'pathology_type' => $request->pathology_type,
                    'description' => $request->description,
                    'clinical_notes' => $request->clinical_notes,
                    'request_date' => $request->request_date,
                    'expected_result_date' => $request->expected_result_date,
                    'actual_result_date' => $request->actual_result_date,
                    'status' => $request->status,
                    'result' => $request->result,
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
                                    'attachment_type_id' => $attachmentData['attachment_type_id'] ?? null,
                                    'attachment_type' => $attachmentData['attachment_type'] ?? null,
                                    'attachment_name' => $attachmentData['attachment_name'] ?? null,
                                    'file_path' => $filePath, // حفظ المسار النسبي فقط
                                    'original_filename' => basename($filePath),
                                    'mime_type' => file_exists($fullPath) ? mime_content_type($fullPath) : null,
                                    'file_size' => file_exists($fullPath) ? filesize($fullPath) : null,
                                    'notes' => $attachmentData['notes'] ?? null,
                                ]);
                            } else {
                                // تحديث فقط النوع والاسم والملاحظات (الملف لم يتغير)
                                $existingAttachment->update([
                                    'attachment_type_id' => $attachmentData['attachment_type_id'] ?? null,
                                    'attachment_type' => $attachmentData['attachment_type'] ?? null,
                                    'attachment_name' => $attachmentData['attachment_name'] ?? null,
                                    'notes' => $attachmentData['notes'] ?? null,
                                ]);
                            }
                        }
                    } else {
                        // إنشاء مرفق جديد
                        $visit->attachmentFiles()->create([
                            'attachment_type_id' => $attachmentData['attachment_type_id'] ?? null,
                            'attachment_type' => $attachmentData['attachment_type'] ?? null,
                            'attachment_name' => $attachmentData['attachment_name'] ?? null,
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
        if (isset($data['imagingStudiesData'])) {
            \Log::info('EditVisit - Starting imaging studies update');

            // حذف الطلبات القديمة
            \DB::table('visit_imaging_studies')->where('visit_id', $visit->id)->delete();

            // إضافة الطلبات الجديدة
            if (!empty($data['imagingStudiesData'])) {
                foreach ($data['imagingStudiesData'] as $imagingData) {
                    \Log::info('EditVisit - Processing imaging study:', ['imagingData' => $imagingData]);
                    if (isset($imagingData['attachment_type_id'])) {
                        \DB::table('visit_imaging_studies')->insert([
                            'visit_id' => $visit->id,
                            'attachment_type_id' => $imagingData['attachment_type_id'],
                            'notes' => $imagingData['notes'] ?? null,
                            'findings' => null,
                            'impression' => null,
                            'study_date' => null,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
            \Log::info('EditVisit - Imaging studies update completed');
        } else {
            \Log::warning('EditVisit - imagingStudiesData is empty or not set');
        }

        // ==================== حفظ/تحديث نتائج التحاليل (النظام الجديد) ====================
        if (isset($data['lab_test_results_data'])) {
            // الحصول على معرفات النتائج الموجودة في النموذج
            $existingIds = collect($data['lab_test_results_data'])
                ->pluck('id')
                ->filter()
                ->toArray();

            // حذف النتائج التي تم إزالتها من النموذج
            $visit->labTestResults()
                ->whereNotIn('id', $existingIds)
                ->get()
                ->each(function ($result) {
                    $result->delete();
                });

            // إضافة أو تحديث النتائج
            foreach ($data['lab_test_results_data'] as $resultData) {
                if (isset($resultData['lab_test_id']) && isset($resultData['result_value'])) {
                    // معالجة صورة التحليل (رفع أو تحديث)
                    $attachmentFileId = $resultData['attachment_file_id'] ?? null;

                    if (isset($resultData['lab_image_path']) && $resultData['lab_image_path']) {
                        $filePath = $resultData['lab_image_path'];

                        // تحقق من تغيير الصورة
                        $imageChanged = false;
                        if ($attachmentFileId) {
                            $existingAttachment = $visit->attachmentFiles()->find($attachmentFileId);
                            if ($existingAttachment && $existingAttachment->file_path !== $filePath) {
                                $imageChanged = true;
                            }
                        } else {
                            $imageChanged = true; // صورة جديدة
                        }

                        if ($imageChanged) {
                            $fullPath = public_path('medical-attachments/' . $filePath);

                            // إذا كانت هناك صورة قديمة، احذفها
                            if ($attachmentFileId) {
                                $oldAttachment = $visit->attachmentFiles()->find($attachmentFileId);
                                if ($oldAttachment) {
                                    $oldAttachment->delete();
                                }
                            }

                            // رفع الصورة الجديدة
                            // الحصول على attachment_type_id لنوع "تقرير تحاليل"
                            $labReportType = \App\Models\AttachmentType::where('name_ar', 'تقرير تحاليل')
                                ->orWhere('name_en', 'Lab Report')
                                ->first();

                            $attachmentFile = $visit->attachmentFiles()->create([
                                'attachment_type_id' => $labReportType ? $labReportType->id : null,
                                'attachment_type' => 'lab-report',
                                'file_path' => $filePath,
                                'original_filename' => basename($filePath),
                                'mime_type' => file_exists($fullPath) ? mime_content_type($fullPath) : null,
                                'file_size' => file_exists($fullPath) ? filesize($fullPath) : null,
                                'notes' => 'صورة تحليل: ' . ($resultData['notes'] ?? ''),
                                'uploaded_by' => auth()->id(),
                            ]);
                            $attachmentFileId = $attachmentFile->id;
                        }
                    }

                    if (isset($resultData['id']) && $resultData['id']) {
                        // تحديث نتيجة موجودة
                        $existingResult = $visit->labTestResults()->find($resultData['id']);
                        if ($existingResult) {
                            $existingResult->update([
                                'lab_test_id' => $resultData['lab_test_id'],
                                'attachment_file_id' => $attachmentFileId,
                                'test_date' => $resultData['test_date'] ?? now(),
                                'result_value' => $resultData['result_value'],
                                'reference_range' => $resultData['reference_range'] ?? null,
                                'unit' => $resultData['unit'] ?? null,
                                'is_normal' => $resultData['is_normal'] ?? null,
                                'previous_value' => $resultData['previous_value'] ?? null,
                                'previous_test_date' => $resultData['previous_test_date'] ?? null,
                                'notes' => $resultData['notes'] ?? null,
                            ]);
                        }
                    } else {
                        // إنشاء نتيجة جديدة
                        $visit->labTestResults()->create([
                            'lab_test_id' => $resultData['lab_test_id'],
                            'attachment_file_id' => $attachmentFileId,
                            'test_date' => $resultData['test_date'] ?? now(),
                            'result_value' => $resultData['result_value'],
                            'reference_range' => $resultData['reference_range'] ?? null,
                            'unit' => $resultData['unit'] ?? null,
                            'is_normal' => $resultData['is_normal'] ?? null,
                            'previous_value' => $resultData['previous_value'] ?? null,
                            'previous_test_date' => $resultData['previous_test_date'] ?? null,
                            'notes' => $resultData['notes'] ?? null,
                        ]);
                    }
                }
            }
        }

        // ==================== تحديث طلبات التشريح المرضي ====================
        if (isset($data['pathologyRequestsData'])) {
            // حذف الطلبات التي تم إزالتها
            $submittedIds = collect($data['pathologyRequestsData'])
                ->filter(fn($item) => isset($item['id']))
                ->pluck('id')
                ->toArray();

            $visit->pathologyRequests()
                ->whereNotIn('id', $submittedIds)
                ->delete();

            // إضافة أو تحديث الطلبات
            foreach ($data['pathologyRequestsData'] as $requestData) {
                if (isset($requestData['id'])) {
                    // تحديث طلب موجود
                    $visit->pathologyRequests()->where('id', $requestData['id'])->update([
                        'pathology_type' => $requestData['pathology_type'],
                        'description' => $requestData['description'] ?? null,
                        'clinical_notes' => $requestData['clinical_notes'] ?? null,
                        'request_date' => $requestData['request_date'] ?? now(),
                        'expected_result_date' => $requestData['expected_result_date'] ?? null,
                        'actual_result_date' => $requestData['actual_result_date'] ?? null,
                        'status' => $requestData['status'] ?? 'pending',
                        'result' => $requestData['result'] ?? null,
                    ]);
                } else {
                    // إنشاء طلب جديد
                    $visit->pathologyRequests()->create([
                        'patient_id' => $visit->patient_id,
                        'pathology_type' => $requestData['pathology_type'],
                        'description' => $requestData['description'] ?? null,
                        'clinical_notes' => $requestData['clinical_notes'] ?? null,
                        'request_date' => $requestData['request_date'] ?? now(),
                        'expected_result_date' => $requestData['expected_result_date'] ?? null,
                        'actual_result_date' => $requestData['actual_result_date'] ?? null,
                        'status' => $requestData['status'] ?? 'pending',
                        'result' => $requestData['result'] ?? null,
                    ]);
                }
            }
        }
    }
}
