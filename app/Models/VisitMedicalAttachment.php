<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitMedicalAttachment extends Model
{
    protected $fillable = [
        'visit_id',
        'medical_referral',
        // الأشعة
        'has_abdominal_ultrasound', 'has_xray', 'has_ct_scan', 'has_mri', 'radiology_notes',
        // التنظير
        'has_upper_endoscopy', 'has_colonoscopy', 'has_eus', 'has_ercp', 'endoscopy_notes',
        // التشريح المرضي
        'has_esophagus_pathology', 'has_stomach_pathology', 'has_duodenum_pathology',
        'has_ileum_pathology', 'has_colon_pathology', 'has_liver_pathology',
        'has_pancreas_pathology', 'pathology_notes',
        // المخبر
        'lab_results',
    ];

    protected $casts = [
        'has_abdominal_ultrasound' => 'boolean',
        'has_xray' => 'boolean',
        'has_ct_scan' => 'boolean',
        'has_mri' => 'boolean',
        'has_upper_endoscopy' => 'boolean',
        'has_colonoscopy' => 'boolean',
        'has_eus' => 'boolean',
        'has_ercp' => 'boolean',
        'has_esophagus_pathology' => 'boolean',
        'has_stomach_pathology' => 'boolean',
        'has_duodenum_pathology' => 'boolean',
        'has_ileum_pathology' => 'boolean',
        'has_colon_pathology' => 'boolean',
        'has_liver_pathology' => 'boolean',
        'has_pancreas_pathology' => 'boolean',
    ];

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }
}
