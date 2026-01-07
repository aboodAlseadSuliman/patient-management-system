<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hospital_consultations', function (Blueprint $table) {
            $table->id();
            
            // معلومات المريض والزيارة
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->string('sequential_number')->unique(); // 260181-260199
            $table->date('consultation_date');
            $table->string('day_of_week', 20); // السبت-الجمعة
            
            // معلومات المشفى والمصدر
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->enum('source', ['hospital', 'consultation', 'private']); // مشفى/استشارة/خاص
            $table->foreignId('doctor_id')->nullable()->constrained('users')->nullOnDelete();
            
            // التشخيص والمتابعة
            $table->foreignId('preliminary_diagnosis_id')->nullable()->constrained()->nullOnDelete();
            $table->text('preliminary_diagnosis_notes')->nullable(); // ملاحظات إضافية
            $table->text('accompanying_diseases')->nullable(); // الأمراض المرافقة (json أو text)
            $table->text('procedures')->nullable(); // الإجراءات
            $table->text('final_diagnosis')->nullable(); // التشخيص النهائي
            $table->enum('follow_up_status', ['cured', 'ongoing', 'deceased'])->nullable(); // شفاء/مستمر/وفاة
            
            // ملاحظات عامة
            $table->text('notes')->nullable();
            
            // تتبع
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
            $table->softDeletes();
            
            // فهارس
            $table->index('consultation_date');
            $table->index(['hospital_id', 'consultation_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospital_consultations');
    }
};
