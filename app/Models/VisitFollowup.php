<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitFollowup extends Model
{
    protected $fillable = [
        'visit_id',
        // التشخيص المبدئي (18)
        'ulcers_for_study', 'dysphagia_for_study', 'suspected_gerd',
        'dyspepsia_for_study', 'anemia_for_study', 'gi_bleeding_for_study',
        'suspected_malabsorption', 'suspected_ibd', 'ibs_for_study',
        'chronic_diarrhea_for_study', 'suspected_intestinal_obstruction', 'suspected_acute_abdomen',
        'ascites_for_study', 'elevated_liver_enzymes_for_study', 'hepatitis_for_study',
        'suspected_cirrhosis', 'liver_masses_for_study', 'biliary_obstruction_for_study',
        // التشخيص النهائي (1)
        'final_diagnosis',
        // الأمراض المزمنة (4)
        'chronic_esophagus_stomach', 'chronic_intestines_colon',
        'chronic_liver', 'chronic_biliary_pancreas',
        // المراجعة (2)
        'followup_required', 'followup_period',
        // الحالة النهائية (1)
        'final_status',
    ];

    protected $casts = [
        // التشخيص المبدئي (18 booleans)
        'ulcers_for_study' => 'boolean',
        'dysphagia_for_study' => 'boolean',
        'suspected_gerd' => 'boolean',
        'dyspepsia_for_study' => 'boolean',
        'anemia_for_study' => 'boolean',
        'gi_bleeding_for_study' => 'boolean',
        'suspected_malabsorption' => 'boolean',
        'suspected_ibd' => 'boolean',
        'ibs_for_study' => 'boolean',
        'chronic_diarrhea_for_study' => 'boolean',
        'suspected_intestinal_obstruction' => 'boolean',
        'suspected_acute_abdomen' => 'boolean',
        'ascites_for_study' => 'boolean',
        'elevated_liver_enzymes_for_study' => 'boolean',
        'hepatitis_for_study' => 'boolean',
        'suspected_cirrhosis' => 'boolean',
        'liver_masses_for_study' => 'boolean',
        'biliary_obstruction_for_study' => 'boolean',
        // المراجعة
        'followup_required' => 'boolean',
    ];

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }
}
