<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReferringDoctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'specialty',
        'clinic_address',
        'clinic_phone',
        'mobile_phone',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ==================== Scopes ====================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ==================== Relationships ====================

    public function patients()
    {
        return $this->hasMany(Patient::class, 'referring_doctor_id');
    }

    // ==================== Helpers ====================

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }
}
