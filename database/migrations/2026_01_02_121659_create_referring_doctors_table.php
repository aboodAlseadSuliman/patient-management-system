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
        Schema::create('referring_doctors', function (Blueprint $table) {
            $table->id();

            // البيانات الشخصية
            $table->string('first_name')->comment('الاسم الأول');
            $table->string('last_name')->comment('الكنية / اسم العائلة');
            $table->string('full_name')->virtualAs("CONCAT(first_name, ' ', last_name)")->comment('الاسم الكامل');

            // التخصص
            $table->string('specialty')->nullable()->comment('التخصص');

            // معلومات التواصل
            $table->string('clinic_address')->nullable()->comment('عنوان العيادة');
            $table->string('clinic_phone', 20)->nullable()->comment('رقم العيادة');
            $table->string('mobile_phone', 20)->nullable()->comment('رقم الجوال');

            // حالة النشاط
            $table->boolean('is_active')->default(true)->comment('نشط');

            // ملاحظات
            $table->text('notes')->nullable()->comment('ملاحظات');

            $table->timestamps();

            // Indexes
            $table->index('first_name');
            $table->index('last_name');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referring_doctors');
    }
};
