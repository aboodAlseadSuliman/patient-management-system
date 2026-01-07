<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EndoscopyProcedure extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'sequential_number',
        'procedure_date',
        'day_of_week',
        'hospital_id',
        'admission_type',
        'source',
        'doctor_id',
        'indication_id',
        'indication_notes',
        'procedure_type',
        'result_text',
        'biopsy_locations',
        'biopsy_results',
        'follow_up_status',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'procedure_date' => 'date',
        'biopsy_locations' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($procedure) {
            if (!$procedure->sequential_number) {
                $procedure->sequential_number = self::generateSequentialNumber();
            }
            
            if (!$procedure->day_of_week) {
                $procedure->day_of_week = self::getDayOfWeekInArabic($procedure->procedure_date);
            }

            if (auth()->check()) {
                $procedure->created_by = auth()->id();
                $procedure->updated_by = auth()->id();
            }
        });

        static::updating(function ($procedure) {
            if (auth()->check()) {
                $procedure->updated_by = auth()->id();
            }
        });
    }

    public static function generateSequentialNumber(): string
    {
        $lastRecord = self::latest('id')->first();
        $nextNumber = $lastRecord ? $lastRecord->id + 1 : 1;
        
        return 'E' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }

    public static function getDayOfWeekInArabic($date): string
    {
        $days = [
            'Sunday' => 'الأحد',
            'Monday' => 'الاثنين',
            'Tuesday' => 'الثلاثاء',
            'Wednesday' => 'الأربعاء',
            'Thursday' => 'الخميس',
            'Friday' => 'الجمعة',
            'Saturday' => 'السبت',
        ];

        return $days[date('l', strtotime($date))] ?? '';
    }

    // ==================== Relationships ====================

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function indication()
    {
        return $this->belongsTo(PreliminaryDiagnosis::class, 'indication_id');
    }

    public function interventions()
    {
        return $this->belongsToMany(
            EndoscopyIntervention::class,
            'procedure_interventions',
            'procedure_id',
            'intervention_id'
        )->withPivot('notes')->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Polymorphic للمرفقات (صور/فيديوهات التنظير)
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    // ==================== Scopes ====================

    public function scopeToday($query)
    {
        return $query->whereDate('procedure_date', today());
    }

    public function scopeByHospital($query, $hospitalId)
    {
        return $query->where('hospital_id', $hospitalId);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('procedure_date', [$startDate, $endDate]);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('procedure_type', $type);
    }
}
