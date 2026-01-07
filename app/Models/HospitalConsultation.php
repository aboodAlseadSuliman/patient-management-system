<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HospitalConsultation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'sequential_number',
        'consultation_date',
        'day_of_week',
        'hospital_id',
        'source',
        'doctor_id',
        'preliminary_diagnosis_id',
        'preliminary_diagnosis_notes',
        'accompanying_diseases',
        'procedures',
        'final_diagnosis',
        'follow_up_status',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'consultation_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($consultation) {
            if (!$consultation->sequential_number) {
                $consultation->sequential_number = self::generateSequentialNumber();
            }
            
            if (!$consultation->day_of_week) {
                $consultation->day_of_week = self::getDayOfWeekInArabic($consultation->consultation_date);
            }

            if (auth()->check()) {
                $consultation->created_by = auth()->id();
                $consultation->updated_by = auth()->id();
            }
        });

        static::updating(function ($consultation) {
            if (auth()->check()) {
                $consultation->updated_by = auth()->id();
            }
        });
    }

    public static function generateSequentialNumber(): string
    {
        $lastRecord = self::latest('id')->first();
        $nextNumber = $lastRecord ? $lastRecord->id + 1 : 1;
        
        // رقم تسلسلي 260181-260199
        if ($nextNumber > 99) {
            $nextNumber = 81;
        }
        
        return '2601' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
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

    public function preliminaryDiagnosis()
    {
        return $this->belongsTo(PreliminaryDiagnosis::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Polymorphic للمرفقات
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    // ==================== Scopes ====================

    public function scopeToday($query)
    {
        return $query->whereDate('consultation_date', today());
    }

    public function scopeByHospital($query, $hospitalId)
    {
        return $query->where('hospital_id', $hospitalId);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('consultation_date', [$startDate, $endDate]);
    }
}
