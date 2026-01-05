<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitTreatmentPlan extends Model
{
    protected $fillable = [
        'visit_id',
        // التعليمات والحمية (11)
        'gerd_instructions', 'dyspepsia_instructions', 'ibs_instructions',
        'constipation_instructions', 'gastroenteritis_instructions', 'celiac_instructions',
        'ibd_instructions', 'hemorrhoids_fissure_instructions', 'hepatitis_a_instructions',
        'hepatitis_b_instructions', 'cirrhosis_instructions',
        // الوصفة الدوائية (4)
        'medication_name', 'medication_form', 'usage_instructions', 'duration',
        // التحاليل والأشعة (2)
        'requested_lab_tests', 'requested_imaging',
        // التنظير (5)
        'needs_upper_endoscopy', 'needs_colonoscopy', 'needs_ercp',
        'needs_guided_biopsy', 'endoscopy_notes',
        // الإحالة والاستشارات (1)
        'referrals_consultations',
    ];

    protected $casts = [
        'needs_upper_endoscopy' => 'boolean',
        'needs_colonoscopy' => 'boolean',
        'needs_ercp' => 'boolean',
        'needs_guided_biopsy' => 'boolean',
    ];

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }
}
