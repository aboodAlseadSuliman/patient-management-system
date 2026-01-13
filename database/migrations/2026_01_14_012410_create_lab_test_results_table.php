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
        Schema::create('lab_test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained('visits')->onDelete('cascade');
            $table->foreignId('lab_test_id')->constrained('lab_tests')->onDelete('cascade');
            $table->date('test_date')->nullable()->comment('تاريخ إجراء التحليل');
            $table->string('result_value')->nullable()->comment('قيمة النتيجة');
            $table->string('reference_range')->nullable()->comment('المجال الطبيعي (مثل: 12-16)');
            $table->string('unit', 50)->nullable()->comment('الوحدة (mg/dL, mmol/L, etc.)');
            $table->boolean('is_normal')->nullable()->comment('هل النتيجة طبيعية؟');
            $table->string('previous_value')->nullable()->comment('القيمة السابقة للمقارنة');
            $table->date('previous_test_date')->nullable()->comment('تاريخ التحليل السابق');
            $table->text('notes')->nullable()->comment('ملاحظات إضافية');
            $table->timestamps();

            // Indexes for better performance
            $table->index('visit_id');
            $table->index('lab_test_id');
            $table->index('test_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_test_results');
    }
};
