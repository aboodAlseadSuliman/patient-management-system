<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitTimeline extends Model
{
    protected $fillable = [
        'visit_id',
        // الخط الزمني
        'onset', 'frequency', 'evolution',
        // العوامل المحرضة
        'food_triggers', 'psychological_triggers', 'medication_triggers',
        'physical_triggers', 'stimulant_triggers', 'smoking_trigger', 'other_triggers',
        // عوامل الخطورة
        'loss_of_appetite', 'weight_loss_amount', 'gi_bleeding', 'night_symptoms',
        'recent_symptoms', 'recurrent_ulcers', 'dysphagia_risk', 'recurrent_vomiting',
        'bowel_habit_change_risk', 'family_history', 'other_risk_factors',
        // التاريخ المرضي
        'medical_conditions', 'current_medications', 'previous_surgeries',
    ];

    protected $casts = [
        'smoking_trigger' => 'boolean',
        'loss_of_appetite' => 'boolean',
        'night_symptoms' => 'boolean',
        'recent_symptoms' => 'boolean',
        'recurrent_ulcers' => 'boolean',
        'dysphagia_risk' => 'boolean',
        'recurrent_vomiting' => 'boolean',
        'bowel_habit_change_risk' => 'boolean',
    ];

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }
}
