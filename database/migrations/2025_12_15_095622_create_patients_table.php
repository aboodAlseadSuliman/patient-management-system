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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            // معلومات التعريف
            $table->string('file_number', 50)->unique()->comment('رقم الملف');
            $table->string('national_id', 50)->nullable()->comment('رقم الهوية');

            // البيانات الشخصية
            $table->string('full_name')->comment('الاسم الكامل');
            $table->enum('gender', ['male', 'female'])->comment('الجنس');
            $table->date('date_of_birth')->comment('تاريخ الميلاد');

            // معلومات الاتصال
            $table->string('phone', 20)->nullable();
            $table->string('alternative_phone', 20)->nullable();

            // السكن
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('area', 100)->nullable();

            // حالة المريض
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();

            // Audit
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('file_number');
            $table->index('full_name');
            $table->index('phone');
            $table->index('national_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
