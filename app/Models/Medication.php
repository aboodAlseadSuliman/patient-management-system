<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'generic_name',
        'brand_name',
        'abbreviation',
        'dosage_form',
        'strength',
        'manufacturer',
        'description',
        'common_dosage',
        'side_effects',
        'contraindications',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ==================== Accessors ====================

    public function getFullNameAttribute(): string
    {
        $name = $this->name_ar;

        if ($this->strength) {
            $name .= " ({$this->strength})";
        }

        return $name;
    }

    // ==================== Relationships ====================

    public function permanentPatients()
    {
        return $this->belongsToMany(
            Patient::class,
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

    public function visitMedications()
    {
        return $this->hasMany(VisitMedication::class);
    }

    // ==================== Scopes ====================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
