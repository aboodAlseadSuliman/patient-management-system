<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'abbreviation',
        'category',
        'description',
        'normal_range',
        'unit',
        'usage_count',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'usage_count' => 'integer',
    ];

    // العلاقات
    public function visits()
    {
        return $this->belongsToMany(Visit::class, 'visit_lab_tests')
            ->withPivot(['result', 'notes', 'test_date', 'is_normal'])
            ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeMostUsed($query, $limit = 20)
    {
        return $query->orderBy('usage_count', 'desc')->limit($limit);
    }

    // Helpers
    public function incrementUsage(): void
    {
        $this->increment('usage_count');
    }
}
