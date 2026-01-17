<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('visit_attachment_files', function (Blueprint $table) {
            // إضافة حقل attachment_type_id
            $table->foreignId('attachment_type_id')->nullable()->after('visit_id')->constrained('attachment_types')->nullOnDelete();
        });

        // تحويل البيانات الموجودة من attachment_type (string) إلى attachment_type_id (foreign key)
        $this->migrateExistingData();
    }

    /**
     * تحويل البيانات الموجودة
     */
    protected function migrateExistingData(): void
    {
        $typeMapping = [
            'medical-referral' => 'إحالة طبية',
            'x-ray' => 'أشعة بسيطة (X-Ray)',
            'ultrasound' => 'إيكو بطني (Ultrasound)',
            'ct-scan' => 'طبقي محوري (CT Scan)',
            'mri' => 'رنين مغناطيسي (MRI)',
            'upper-endoscopy' => 'تنظير علوي',
            'colonoscopy' => 'تنظير سفلي (Colonoscopy)',
            'eus' => 'تنظير بالأمواج فوق الصوتية (EUS)',
            'ercp' => 'تنظير القنوات الصفراوية (ERCP)',
            'pathology-esophagus' => 'تشريح مرضي - مريء',
            'pathology-stomach' => 'تشريح مرضي - معدة',
            'pathology-duodenum' => 'تشريح مرضي - اثني عشري',
            'pathology-ileum' => 'تشريح مرضي - دقاق',
            'pathology-colon' => 'تشريح مرضي - كولون',
            'pathology-liver' => 'تشريح مرضي - كبد',
            'pathology-pancreas' => 'تشريح مرضي - بنكرياس',
            'lab-report' => 'تقرير تحاليل',
            'document' => 'مستند طبي',
            'other' => 'أخرى',
        ];

        foreach ($typeMapping as $oldType => $arabicName) {
            $attachmentType = DB::table('attachment_types')->where('name_ar', $arabicName)->first();
            if ($attachmentType) {
                DB::table('visit_attachment_files')
                    ->where('attachment_type', $oldType)
                    ->update(['attachment_type_id' => $attachmentType->id]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visit_attachment_files', function (Blueprint $table) {
            $table->dropForeign(['attachment_type_id']);
            $table->dropColumn('attachment_type_id');
        });
    }
};
