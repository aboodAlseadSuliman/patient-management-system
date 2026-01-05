<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\LabTest;
use App\Models\ImagingStudy;


class Visit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'referring_doctor_id',
        'visit_number',
        'visit_date',
        'visit_type',
        'chief_complaint',
        'associated_symptoms',
        'evolution',
        'triggers',
        'severity',
        'vital_signs',
        'physical_examination',
        'current_medications',
        'previous_surgeries',
        'radiology_findings',
        'endoscopy_findings',
        'proposed_treatment',
        'requested_investigations',
        'general_condition',
        'diagnosis',
        'prescription',
        'next_visit_date',
        'doctor_notes',
        'is_completed',
        'created_by',
        'updated_by',

    ];

    protected $casts = [
        'visit_date' => 'date',
        'next_visit_date' => 'date',
        'vital_signs' => 'array',
        'is_completed' => 'boolean',

    ];




    // ==================== Relationships ====================

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function referringDoctor()
    {
        return $this->belongsTo(ReferringDoctor::class, 'referring_doctor_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // public function doctor()
    // {
    //     return $this->belongsTo(User::class, 'created_by');
    // }

    public function medications()
    {
        return $this->hasMany(VisitMedication::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    // ==================== Scopes ====================

    public function scopeCompleted($query)
    {
        return $query->where('is_completed', true);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('visit_date', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('visit_date', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('visit_date', now()->month)
            ->whereYear('visit_date', now()->year);
    }

    // ==================== Helpers ====================

    public static function generateVisitNumber($patientId): int
    {
        $lastVisit = self::where('patient_id', $patientId)
            ->latest('visit_number')
            ->first();

        return $lastVisit ? $lastVisit->visit_number + 1 : 1;
    }

    public function copyFromLastVisit(): void
    {
        $lastVisit = self::where('patient_id', $this->patient_id)
            ->where('id', '!=', $this->id)
            ->latest('visit_date')
            ->first();

        if ($lastVisit) {
            $this->current_medications = $lastVisit->proposed_treatment;
            $this->previous_surgeries = $lastVisit->previous_surgeries;
        }
    }

    // ==================== Boot ====================

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($visit) {
    //         if (!$visit->visit_number) {
    //             $visit->visit_number = self::generateVisitNumber($visit->patient_id);
    //         }
    //     });



    //     static::creating(function ($visit) {
    //         if (auth()->check()) {
    //             $visit->created_by = auth()->id();
    //             $visit->updated_by = auth()->id();
    //         }
    //     });

    //     static::updating(function ($visit) {
    //         if (auth()->check()) {
    //             $visit->updated_by = auth()->id();
    //         }
    //     });
    // }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($visit) {
            if (!$visit->visit_number) {
                $visit->visit_number = self::generateVisitNumber($visit->patient_id);
            }

            if (auth()->check()) {
                $visit->created_by = auth()->id();
                $visit->updated_by = auth()->id();
            }
        });

        static::updating(function ($visit) {
            if (auth()->check()) {
                $visit->updated_by = auth()->id();
            }
        });
    }

    public function labTests()
    {
        return $this->belongsToMany(LabTest::class, 'visit_lab_tests')
            ->withPivot(['result', 'notes', 'test_date', 'is_normal'])
            ->withTimestamps();
    }

    public function imagingStudies()
    {
        return $this->belongsToMany(ImagingStudy::class, 'visit_imaging_studies')
            ->withPivot(['findings', 'impression', 'study_date', 'notes'])
            ->withTimestamps();
    }

    // العلاقات الجديدة للواجهات الأربعة
    public function complaintSymptom()
    {
        return $this->hasOne(VisitComplaintSymptom::class);
    }

    public function timeline()
    {
        return $this->hasOne(VisitTimeline::class);
    }

    public function medicalAttachment()
    {
        return $this->hasOne(VisitMedicalAttachment::class);
    }

    public function clinicalExamination()
    {
        return $this->hasOne(VisitClinicalExamination::class);
    }

    public function treatmentPlan()
    {
        return $this->hasOne(VisitTreatmentPlan::class);
    }

    public function followup()
    {
        return $this->hasOne(VisitFollowup::class);
    }
}
