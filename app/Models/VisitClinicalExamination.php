<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitClinicalExamination extends Model
{
    protected $fillable = [
        'visit_id',
        // العلامات الحيوية
        'blood_pressure', 'pulse', 'temperature', 'oxygen_saturation',
        // الفحص السريري
        'weight', 'head_neck_exam', 'heart_chest_exam', 'abdomen_pelvis_exam',
        'extremities_exam', 'rectal_exam',
        // إيكو البطن
        'liver_echo', 'gallbladder_echo', 'bile_ducts_echo', 'pancreas_echo',
        'spleen_echo', 'stomach_echo', 'intestines_echo', 'abdominal_cavity_echo',
        'kidneys_echo', 'uterus_appendages_echo', 'prostate_echo', 'other_echo',
    ];

    protected $casts = [
        'pulse' => 'integer',
        'temperature' => 'decimal:2',
        'oxygen_saturation' => 'integer',
        'weight' => 'decimal:2',
    ];

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }
}
