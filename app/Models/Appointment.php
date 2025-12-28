<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'visit_id',
        'appointment_type_id', // ← تغيير من appointment_type
        'appointment_date',
        'appointment_time',
        'duration',
        'status',
        'priority',
        'location',
        'reason',
        'notes',
        'doctor_notes',
        'fee',
        'payment_status',
        'reminder_sent',
        'reminder_sent_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
        'reminder_sent' => 'boolean',
        'reminder_sent_at' => 'datetime',
        'fee' => 'decimal:2',
    ];

    // ==================== Relationships ====================

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }

    // ← جديد: علاقة مع AppointmentType
    public function appointmentType(): BelongsTo
    {
        return $this->belongsTo(AppointmentType::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ==================== Scopes ====================

    public function scopeByType($query, $typeId)
    {
        return $query->where('appointment_type_id', $typeId);
    }

    public function scopeClinic($query)
    {
        return $query->whereHas('appointmentType', function ($q) {
            $q->where('slug', 'clinic');
        });
    }

    public function scopeHospital($query)
    {
        return $query->whereHas('appointmentType', function ($q) {
            $q->where('slug', 'hospital');
        });
    }

    public function scopeEndoscopy($query)
    {
        return $query->whereHas('appointmentType', function ($q) {
            $q->where('slug', 'endoscopy');
        });
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('appointment_date', today());
    }

    public function scopeTomorrow($query)
    {
        return $query->whereDate('appointment_date', today()->addDay());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('appointment_date', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', today())
            ->whereIn('status', ['scheduled', 'confirmed'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time');
    }

    // ==================== Accessors ====================

    public function getFullDateTimeAttribute(): string
    {
        return $this->appointment_date->format('Y-m-d') . ' ' .
            Carbon::parse($this->appointment_time)->format('H:i');
    }

    public function getStatusNameAttribute(): string
    {
        return match ($this->status) {
            'scheduled' => 'مجدول',
            'confirmed' => 'مؤكد',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي',
            'no_show' => 'لم يحضر',
            'rescheduled' => 'معاد جدولة',
            default => $this->status,
        };
    }

    public function getPriorityNameAttribute(): string
    {
        return match ($this->priority) {
            'normal' => 'عادي',
            'urgent' => 'عاجل',
            'emergency' => 'طارئ',
            default => $this->priority,
        };
    }

    // ==================== Helpers ====================

    public function markAsCompleted(): void
    {
        $this->update(['status' => 'completed']);
    }

    public function cancel(): void
    {
        $this->update(['status' => 'cancelled']);
    }

    public function markAsNoShow(): void
    {
        $this->update(['status' => 'no_show']);
    }

    public function sendReminder(): void
    {
        // منطق إرسال التذكير (SMS/Email)
        $this->update([
            'reminder_sent' => true,
            'reminder_sent_at' => now(),
        ]);
    }

    // ==================== Boot ====================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($appointment) {
            if (auth()->check()) {
                $appointment->created_by = auth()->id();
                $appointment->updated_by = auth()->id();
            }
        });

        static::updating(function ($appointment) {
            if (auth()->check()) {
                $appointment->updated_by = auth()->id();
            }
        });
    }
}
