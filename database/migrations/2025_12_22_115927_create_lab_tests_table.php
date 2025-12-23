<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // جدول التحاليل
        Schema::create('lab_tests', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar'); // سكر صائم
            $table->string('name_en')->nullable(); // Fasting Blood Sugar
            $table->string('abbreviation')->nullable(); // FBS
            $table->string('category')->nullable(); // blood, urine, stool
            $table->text('description')->nullable();
            $table->text('normal_range')->nullable(); // 70-110 mg/dl
            $table->string('unit')->nullable(); // mg/dl
            $table->integer('usage_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // جدول ربط التحاليل مع الزيارات
        Schema::create('visit_lab_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lab_test_id')->constrained()->cascadeOnDelete();
            $table->string('result')->nullable(); // النتيجة
            $table->text('notes')->nullable();
            $table->date('test_date')->nullable();
            $table->boolean('is_normal')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visit_lab_tests');
        Schema::dropIfExists('lab_tests');
    }
};
