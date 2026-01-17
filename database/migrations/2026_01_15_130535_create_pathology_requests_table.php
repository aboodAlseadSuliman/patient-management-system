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
        Schema::create('pathology_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();

            // معلومات الطلب
            $table->string('pathology_type')->comment('نوع التشريح: esophagus, stomach, duodenum, ileum, colon, liver, pancreas, other');
            $table->text('description')->nullable()->comment('وصف الطلب');
            $table->text('clinical_notes')->nullable()->comment('ملاحظات سريرية');

            // التواريخ
            $table->date('request_date')->comment('تاريخ الطلب');
            $table->date('expected_result_date')->nullable()->comment('التاريخ المتوقع لصدور النتيجة');
            $table->date('actual_result_date')->nullable()->comment('التاريخ الفعلي لصدور النتيجة');

            // الحالة
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending')->comment('حالة الطلب');

            // النتيجة
            $table->text('result')->nullable()->comment('نتيجة التشريح المرضي');

            // المرفقات
            $table->foreignId('attachment_file_id')->nullable()->constrained('visit_attachment_files')->nullOnDelete()->comment('ملف نتيجة التشريح');

            $table->timestamps();

            // Indexes للبحث السريع
            $table->index(['status', 'expected_result_date']);
            $table->index(['patient_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pathology_requests');
    }
};
