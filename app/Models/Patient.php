<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'file_number',
        'national_id',
        'full_name',
        'first_name',
        'father_name',
        'last_name',
        'gender',
        'date_of_birth',
        'birth_year',
        'phone',
        'country',
        'province',
        'neighborhood',
        'occupation',
        'referring_doctor_id',
        'is_active',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
    ];

    protected $appends = ['age_years'];

    // ==================== Accessors ====================

    public function getAgeYearsAttribute()
    {
        return $this->date_of_birth ?
            now()->diffInYears($this->date_of_birth) : null;
    }

    public function getAgeDisplayAttribute(): string
    {
        if (!$this->date_of_birth) {
            return 'غير محدد';
        }

        $years = now()->diffInYears($this->date_of_birth);
        $months = now()->diffInMonths($this->date_of_birth) % 12;

        if ($years == 0) {
            return "{$months} شهر";
        }

        if ($months == 0) {
            return "{$years} سنة";
        }

        return "{$years} سنة و {$months} شهر";
    }



    protected static function boot()
    {
        parent::boot();

        // عند إنشاء مريض جديد
        static::creating(function ($patient) {
            // ملء الاسم الكامل تلقائياً
            $patient->full_name = self::buildFullName(
                $patient->first_name,
                $patient->father_name,
                $patient->last_name
            );

            if (auth()->check()) {
                $patient->created_by = auth()->id();
                $patient->updated_by = auth()->id();
            }
        });

        // عند تحديث مريض
        static::updating(function ($patient) {
            // تحديث الاسم الكامل إذا تغير أي من أجزاء الاسم
            if ($patient->isDirty(['first_name', 'father_name', 'last_name'])) {
                $patient->full_name = self::buildFullName(
                    $patient->first_name,
                    $patient->father_name,
                    $patient->last_name
                );
            }

            if (auth()->check()) {
                $patient->updated_by = auth()->id();
            }
        });
    }

    /**
     * بناء الاسم الكامل من أجزاء الاسم
     */
    private static function buildFullName(?string $firstName, ?string $fatherName, ?string $lastName): string
    {
        $parts = array_filter([$firstName, $fatherName, $lastName]);
        return implode(' ', $parts);
    }


    // ==================== Relationships ====================

    public function visits()
    {
        return $this->hasMany(Visit::class)->orderBy('visit_date', 'desc');
    }

    public function lastVisit()
    {
        return $this->hasOne(Visit::class)->latestOfMany('visit_date');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function chronicDiseases()
    {
        return $this->belongsToMany(
            ChronicDisease::class,
            'patient_chronic_diseases'
        )->withPivot(['diagnosis_date', 'notes', 'is_active'])
            ->withTimestamps();
    }

    public function activeChronicDiseases()
    {
        return $this->chronicDiseases()->wherePivot('is_active', true);
    }

    public function permanentMedications()
    {
        return $this->belongsToMany(
            Medication::class,
            'patient_permanent_medications'
        )->withPivot([
            'dosage',
            'frequency',
            'route',
            'start_date',
            'end_date',
            'notes',
            'is_active'
        ])->withTimestamps();
    }

    public function activePermanentMedications()
    {
        return $this->permanentMedications()->wherePivot('is_active', true);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function referringDoctor()
    {
        return $this->belongsTo(ReferringDoctor::class, 'referring_doctor_id');
    }

    public function hospitalConsultations()
    {
        return $this->hasMany(HospitalConsultation::class);
    }

    public function endoscopyProcedures()
    {
        return $this->hasMany(EndoscopyProcedure::class);
    }

    // ==================== Scopes ====================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('file_number', 'like', "%{$search}%")
                ->orWhere('full_name', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('national_id', 'like', "%{$search}%");
        });
    }

    // ==================== Helpers ====================

    public static function generateFileNumber(): string
    {
        $lastPatient = self::latest('id')->first();
        $nextNumber = $lastPatient ? $lastPatient->id + 1 : 1;

        return 'P' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }
}
