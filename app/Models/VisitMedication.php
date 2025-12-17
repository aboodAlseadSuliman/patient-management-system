<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitMedication extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_id',
        'medication_id',
        'medication_text',
        'dosage',
        'frequency',
        'duration',
        'route',
        'notes',
    ];

    // ==================== Relationships ====================

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }

    // ==================== Accessors ====================

    public function getMedicationNameAttribute(): string
    {
        return $this->medication?->name_ar ?? $this->medication_text ?? 'غير محدد';
    }
}
