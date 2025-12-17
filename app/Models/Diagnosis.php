<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'abbreviation',
        'icd_code',
        'category',
        'description',
        'is_chronic',
        'usage_count',
        'is_active',
    ];

    protected $casts = [
        'is_chronic' => 'boolean',
        'is_active' => 'boolean',
        'usage_count' => 'integer',
    ];

    // ==================== Scopes ====================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeMostUsed($query, $limit = 10)
    {
        return $query->orderBy('usage_count', 'desc')->limit($limit);
    }

    // ==================== Helpers ====================

    public function incrementUsage(): void
    {
        $this->increment('usage_count');
    }
}
