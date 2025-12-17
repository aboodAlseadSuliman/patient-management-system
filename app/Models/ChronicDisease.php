<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChronicDisease extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'abbreviation',
        'description',
        'icd_code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ==================== Relationships ====================

    public function patients()
    {
        return $this->belongsToMany(
            Patient::class,
            'patient_chronic_diseases'
        )->withPivot(['diagnosis_date', 'notes', 'is_active'])
            ->withTimestamps();
    }

    // ==================== Scopes ====================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
