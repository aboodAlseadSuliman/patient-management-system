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
        'gender',
        'date_of_birth',
        'phone',
        'alternative_phone',
        'address',
        'city',
        'area',
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
