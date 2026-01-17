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
        Schema::table('visits', function (Blueprint $table) {
            // حذف الأعمدة التي صارت بيانات مقسمة في جداول منفصلة

            // بيانات الشكاية (موجودة الآن في visit_complaint_symptoms)
            $table->dropColumn([
                'chief_complaint',
                'associated_symptoms',
                'evolution',
                'triggers',
                'severity',
            ]);

            // بيانات الفحص السريري (موجودة في visit_clinical_examinations)
            $table->dropColumn([
                'vital_signs',
                'physical_examination',
            ]);

            // بيانات التاريخ الطبي (موجودة في patient_chronic_diseases و patient_permanent_medications)
            $table->dropColumn([
                'current_medications',
                'previous_surgeries',
            ]);

            // نتائج الفحوصات (موجودة في visit_attachment_files)
            $table->dropColumn([
                'radiology_findings',
                'endoscopy_findings',
            ]);

            // الخطة العلاجية (موجودة في visit_treatment_plans)
            $table->dropColumn([
                'proposed_treatment',
                'requested_investigations',
            ]);

            // التشخيص والوصفة (موجودة في visit_followups و visit_medications)
            $table->dropColumn([
                'general_condition',
                'diagnosis',
                'prescription',
            ]);

            // تاريخ الزيارة القادمة (موجود في visit_followups)
            $table->dropColumn('next_visit_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            // استعادة الأعمدة في حالة الـ rollback
            $table->text('chief_complaint')->nullable();
            $table->text('associated_symptoms')->nullable();
            $table->text('evolution')->nullable();
            $table->text('triggers')->nullable();
            $table->text('severity')->nullable();

            $table->json('vital_signs')->nullable();
            $table->text('physical_examination')->nullable();

            $table->text('current_medications')->nullable();
            $table->text('previous_surgeries')->nullable();

            $table->text('radiology_findings')->nullable();
            $table->text('endoscopy_findings')->nullable();

            $table->text('proposed_treatment')->nullable();
            $table->text('requested_investigations')->nullable();

            $table->text('general_condition')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('prescription')->nullable();

            $table->date('next_visit_date')->nullable();
        });
    }
};
