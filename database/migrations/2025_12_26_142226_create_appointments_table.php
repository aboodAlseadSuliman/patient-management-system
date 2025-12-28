<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            // العلاقات
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('visit_id')->nullable()->constrained()->nullOnDelete();

            // نوع الموعد
            $table->foreignId('appointment_type_id')
                ->constrained('appointment_types')
                ->cascadeOnDelete();

            // التاريخ والوقت
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->integer('duration')->default(30); // بالدقائق

            // الحالة
            $table->enum('status', [
                'scheduled',   // مجدول
                'confirmed',   // مؤكد
                'completed',   // مكتمل
                'cancelled',   // ملغي
                'no_show',     // لم يحضر
                'rescheduled', // معاد جدولة
            ])->default('scheduled');

            // الأولوية
            $table->enum('priority', [
                'normal',      // عادي
                'urgent',      // عاجل
                'emergency',   // طارئ
            ])->default('normal');

            // معلومات إضافية
            $table->string('location')->nullable(); // رقم الغرفة/العيادة
            $table->text('reason')->nullable(); // سبب الزيارة
            $table->text('notes')->nullable(); // ملاحظات عامة
            $table->text('doctor_notes')->nullable(); // ملاحظات الطبيب

            // المالية (اختياري)
            $table->decimal('fee', 10, 2)->nullable();
            $table->enum('payment_status', [
                'pending',     // معلق
                'paid',        // مدفوع
                'partial',     // جزئي
            ])->default('pending');

            // التذكيرات
            $table->boolean('reminder_sent')->default(false);
            $table->timestamp('reminder_sent_at')->nullable();

            // تتبع الإنشاء والتعديل
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['appointment_date', 'appointment_time']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
