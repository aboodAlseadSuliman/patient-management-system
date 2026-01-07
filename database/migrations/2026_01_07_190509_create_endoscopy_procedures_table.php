<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('endoscopy_procedures', function (Blueprint $table) {
            $table->id();
            
            // معلومات المريض والإجراء
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->string('sequential_number')->unique();
            $table->date('procedure_date');
            $table->string('day_of_week', 20);
            
            // معلومات المشفى والقبول
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->enum('admission_type', ['internal', 'external']);
            $table->string('source');
            $table->foreignId('doctor_id')->nullable()->constrained('users')->nullOnDelete();
            
            // الاستطباب والإجراء
            $table->foreignId('indication_id')->nullable()->constrained('preliminary_diagnoses')->nullOnDelete();
            $table->text('indication_notes')->nullable();
            $table->enum('procedure_type', ['upper', 'lower', 'biopsy']);
            
            // النتائج
            $table->text('result_text')->nullable();
            $table->json('biopsy_locations')->nullable();
            $table->text('biopsy_results')->nullable();
            
            // المتابعة
            $table->enum('follow_up_status', ['completed', 'ongoing'])->nullable();
            
            // ملاحظات
            $table->text('notes')->nullable();
            
            // تتبع
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
            $table->softDeletes();
            
            // فهارس
            $table->index('procedure_date');
            $table->index(['hospital_id', 'procedure_date']);
        });
        
        // جدول pivot للتداخلات (many-to-many) - بأسماء قصيرة
        Schema::create('procedure_interventions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('procedure_id')->constrained('endoscopy_procedures')->cascadeOnDelete();
            $table->foreignId('intervention_id')->constrained('endoscopy_interventions')->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['procedure_id', 'intervention_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('procedure_interventions');
        Schema::dropIfExists('endoscopy_procedures');
    }
};
