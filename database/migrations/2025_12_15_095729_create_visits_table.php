<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->integer('visit_number');

            $table->date('visit_date')->default(DB::raw('CURRENT_DATE'));
            $table->enum('visit_type', ['first_visit', 'follow_up', 'emergency'])
                ->default('follow_up');

            // الشكاية والمعلومات السريرية
            $table->text('chief_complaint')->nullable();
            $table->text('associated_symptoms')->nullable();
            $table->text('evolution')->nullable();
            $table->text('triggers')->nullable();
            $table->text('severity')->nullable();

            $table->json('vital_signs')->nullable();
            $table->text('physical_examination')->nullable();

            // التاريخ الطبي
            $table->text('current_medications')->nullable();
            $table->text('previous_surgeries')->nullable();

            // الفحوصات
            $table->text('radiology_findings')->nullable();
            $table->text('endoscopy_findings')->nullable();

            // الخطة العلاجية
            $table->text('proposed_treatment')->nullable();
            $table->text('requested_investigations')->nullable();

            // التقييم
            $table->text('general_condition')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('prescription')->nullable();

            $table->date('next_visit_date')->nullable();
            $table->text('doctor_notes')->nullable();

            $table->boolean('is_completed')->default(false);

            // Audit
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index('patient_id');
            $table->index('visit_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
