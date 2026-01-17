<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE VIEW upcoming_reminders_view AS

            -- طلبات التشريح المرضي
            SELECT
                CONCAT('pathology_', pr.id) as reminder_id,
                pr.patient_id,
                pr.visit_id,
                'pathology' as reminder_type,
                pr.expected_result_date as reminder_date,
                pr.expected_result_date,
                NULL as calculated_followup_date,
                CONCAT('نتيجة تشريح مرضي - ',
                    CASE pr.pathology_type
                        WHEN 'esophagus' THEN 'مريء'
                        WHEN 'stomach' THEN 'معدة'
                        WHEN 'duodenum' THEN 'اثني عشري'
                        WHEN 'ileum' THEN 'دقاق'
                        WHEN 'colon' THEN 'كولون'
                        WHEN 'liver' THEN 'كبد'
                        WHEN 'pancreas' THEN 'بنكرياس'
                        WHEN 'other' THEN 'أخرى'
                    END,
                    COALESCE(CONCAT(' - ', pr.description), '')
                ) as description,
                pr.created_at,
                pr.updated_at
            FROM pathology_requests pr
            WHERE pr.status IN ('pending', 'in_progress')
                AND pr.expected_result_date IS NOT NULL

            UNION ALL

            -- متابعات المرضى
            SELECT
                CONCAT('followup_', vf.id) as reminder_id,
                v.patient_id,
                vf.visit_id,
                'followup' as reminder_type,
                CASE vf.followup_period
                    WHEN '1_week' THEN DATE_ADD(v.visit_date, INTERVAL 1 WEEK)
                    WHEN '2_weeks' THEN DATE_ADD(v.visit_date, INTERVAL 2 WEEK)
                    WHEN '1_month' THEN DATE_ADD(v.visit_date, INTERVAL 1 MONTH)
                    WHEN '2_months' THEN DATE_ADD(v.visit_date, INTERVAL 2 MONTH)
                    WHEN '3_months' THEN DATE_ADD(v.visit_date, INTERVAL 3 MONTH)
                    WHEN '6_months' THEN DATE_ADD(v.visit_date, INTERVAL 6 MONTH)
                    WHEN '1_year' THEN DATE_ADD(v.visit_date, INTERVAL 1 YEAR)
                END as reminder_date,
                NULL as expected_result_date,
                CASE vf.followup_period
                    WHEN '1_week' THEN DATE_ADD(v.visit_date, INTERVAL 1 WEEK)
                    WHEN '2_weeks' THEN DATE_ADD(v.visit_date, INTERVAL 2 WEEK)
                    WHEN '1_month' THEN DATE_ADD(v.visit_date, INTERVAL 1 MONTH)
                    WHEN '2_months' THEN DATE_ADD(v.visit_date, INTERVAL 2 MONTH)
                    WHEN '3_months' THEN DATE_ADD(v.visit_date, INTERVAL 3 MONTH)
                    WHEN '6_months' THEN DATE_ADD(v.visit_date, INTERVAL 6 MONTH)
                    WHEN '1_year' THEN DATE_ADD(v.visit_date, INTERVAL 1 YEAR)
                END as calculated_followup_date,
                CONCAT('متابعة - ',
                    CASE vf.followup_period
                        WHEN '1_week' THEN 'بعد أسبوع'
                        WHEN '2_weeks' THEN 'بعد أسبوعين'
                        WHEN '1_month' THEN 'بعد شهر'
                        WHEN '2_months' THEN 'بعد شهرين'
                        WHEN '3_months' THEN 'بعد 3 أشهر'
                        WHEN '6_months' THEN 'بعد 6 أشهر'
                        WHEN '1_year' THEN 'بعد سنة'
                    END
                ) as description,
                vf.created_at,
                vf.updated_at
            FROM visit_followups vf
            INNER JOIN visits v ON vf.visit_id = v.id
            WHERE vf.followup_required = 1
                AND vf.followup_period IS NOT NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS upcoming_reminders_view');
    }
};
