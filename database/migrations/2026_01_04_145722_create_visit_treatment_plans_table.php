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
        Schema::create('visit_treatment_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained()->cascadeOnDelete();

            // الواجهة الخامسة: خطة العلاج

            // 1. التعليمات والحمية - 11 حقل
            $table->text('gerd_instructions')->nullable()->comment('القلس المريئي');
            $table->text('dyspepsia_instructions')->nullable()->comment('عسر الهضم');
            $table->text('ibs_instructions')->nullable()->comment('تشنج الكولون');
            $table->text('constipation_instructions')->nullable()->comment('الإمساك');
            $table->text('gastroenteritis_instructions')->nullable()->comment('التهاب الأمعاء');
            $table->text('celiac_instructions')->nullable()->comment('الداء الزلاقي');
            $table->text('ibd_instructions')->nullable()->comment('الداء المعوي الالتهابي');
            $table->text('hemorrhoids_fissure_instructions')->nullable()->comment('البواسير والشق الشرجي');
            $table->text('hepatitis_a_instructions')->nullable()->comment('التهاب الكبد A');
            $table->text('hepatitis_b_instructions')->nullable()->comment('التهاب الكبد B');
            $table->text('cirrhosis_instructions')->nullable()->comment('تشمع الكبد');

            // 2. الوصفة الدوائية - 4 حقول
            $table->text('medication_name')->nullable()->comment('الدواء المطلوب');
            $table->string('medication_form')->nullable()->comment('الشكل الدوائي');
            $table->text('usage_instructions')->nullable()->comment('طريقة الاستخدام');
            $table->string('duration')->nullable()->comment('المدة الزمنية');

            // 3. التحاليل المطلوبة
            $table->text('requested_lab_tests')->nullable()->comment('التحاليل المطلوبة');

            // 4. الأشعة المطلوبة
            $table->text('requested_imaging')->nullable()->comment('الأشعة المطلوبة');

            // 5. التنظير - 5 حقول
            $table->boolean('needs_upper_endoscopy')->default(false)->comment('تنظير علوي');
            $table->boolean('needs_colonoscopy')->default(false)->comment('تنظير سفلي');
            $table->boolean('needs_ercp')->default(false)->comment('ERCP');
            $table->boolean('needs_guided_biopsy')->default(false)->comment('خزعة موجهة');
            $table->text('endoscopy_notes')->nullable()->comment('ملاحظات التنظير');

            // 6. الإحالة والاستشارات
            $table->text('referrals_consultations')->nullable()->comment('الإحالة والاستشارات');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_treatment_plans');
    }
};
