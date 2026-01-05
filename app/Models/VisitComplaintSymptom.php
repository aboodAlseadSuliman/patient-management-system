<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitComplaintSymptom extends Model
{
    protected $fillable = [
        'visit_id',
        // المربع الأول
        'chief_complaint',
        'complaint_characteristics',
        'associated_symptoms',
        // المريء
        'oral_thrush', 'bad_breath', 'mouth_breathing', 'snoring', 'dental_lesions',
        'globus', 'dysphagia', 'odynophagia', 'hiccup', 'esophageal_reflux',
        // المعدة
        'dyspepsia', 'vomiting', 'melena', 'anemia',
        // الأمعاء والكولون
        'growth_failure', 'abdominal_pain', 'colon_spasm', 'bloating_gas',
        'constipation', 'diarrhea', 'bowel_habit_change',
        // المستقيم والشرج
        'difficult_defecation', 'tenesmus', 'rectal_bleeding', 'incontinence',
        'anal_pain', 'anal_itching',
        // الكبد والطرق الصفراوية
        'ascites', 'elevated_liver_enzymes', 'hepatitis', 'jaundice',
        'fatty_liver', 'liver_cirrhosis', 'liver_masses',
        // الأعضاء الأخرى
        'cough', 'dyspnea', 'chest_pain', 'hemoptysis', 'dizziness',
        'tremor', 'mental_confusion', 'dysuria', 'hematuria', 'skin_rash',
        'itching', 'joint_pain', 'fever', 'fatigue', 'weight_loss',
    ];

    protected $casts = [
        'oral_thrush' => 'boolean',
        'bad_breath' => 'boolean',
        'mouth_breathing' => 'boolean',
        'snoring' => 'boolean',
        'dental_lesions' => 'boolean',
        'globus' => 'boolean',
        'odynophagia' => 'boolean',
        'hiccup' => 'boolean',
        'esophageal_reflux' => 'boolean',
        'melena' => 'boolean',
        'growth_failure' => 'boolean',
        'bloating_gas' => 'boolean',
        'constipation' => 'boolean',
        'bowel_habit_change' => 'boolean',
        'difficult_defecation' => 'boolean',
        'tenesmus' => 'boolean',
        'anal_pain' => 'boolean',
        'anal_itching' => 'boolean',
        'ascites' => 'boolean',
        'elevated_liver_enzymes' => 'boolean',
        'liver_cirrhosis' => 'boolean',
        'hemoptysis' => 'boolean',
        'tremor' => 'boolean',
        'mental_confusion' => 'boolean',
        'dysuria' => 'boolean',
        'hematuria' => 'boolean',
        'itching' => 'boolean',
        'fatigue' => 'boolean',
    ];

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }
}
