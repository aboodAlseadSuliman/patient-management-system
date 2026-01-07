<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospital extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_ar',
        'name_en',
        'abbreviation',
        'address',
        'phone',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function hospitalConsultations()
    {
        return $this->hasMany(HospitalConsultation::class);
    }

    public function endoscopyProcedures()
    {
        return $this->hasMany(EndoscopyProcedure::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
