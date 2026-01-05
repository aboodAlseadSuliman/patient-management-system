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
        Schema::create('visit_medical_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained()->cascadeOnDelete();

            // الواجهة الثالثة: المرفقات الطبية

            // 1. الإحالة الطبية
            $table->text('medical_referral')->nullable()->comment('الإحالة الطبية');

            // 2. الأشعة
            $table->boolean('has_abdominal_ultrasound')->default(false)->comment('إيكو بطن');
            $table->boolean('has_xray')->default(false)->comment('أشعة بسيطة');
            $table->boolean('has_ct_scan')->default(false)->comment('طبقي محوري');
            $table->boolean('has_mri')->default(false)->comment('رنين مغناطيسي');
            $table->text('radiology_notes')->nullable()->comment('ملاحظات الأشعة');

            // 3. التنظير
            $table->boolean('has_upper_endoscopy')->default(false)->comment('تنظير علوي');
            $table->boolean('has_colonoscopy')->default(false)->comment('تنظير سفلي');
            $table->boolean('has_eus')->default(false)->comment('EUS');
            $table->boolean('has_ercp')->default(false)->comment('ERCP');
            $table->text('endoscopy_notes')->nullable()->comment('ملاحظات التنظير');

            // 4. التشريح المرضي
            $table->boolean('has_esophagus_pathology')->default(false)->comment('مريء');
            $table->boolean('has_stomach_pathology')->default(false)->comment('معدة');
            $table->boolean('has_duodenum_pathology')->default(false)->comment('اثني عشري');
            $table->boolean('has_ileum_pathology')->default(false)->comment('دقاق');
            $table->boolean('has_colon_pathology')->default(false)->comment('كولون');
            $table->boolean('has_liver_pathology')->default(false)->comment('كبد');
            $table->boolean('has_pancreas_pathology')->default(false)->comment('بنكرياس');
            $table->text('pathology_notes')->nullable()->comment('ملاحظات التشريح المرضي');

            // 5. المخبر - سيتم ربطه بجدول التحاليل الموجود
            $table->text('lab_results')->nullable()->comment('نتائج المخبر');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_medical_attachments');
    }
};
