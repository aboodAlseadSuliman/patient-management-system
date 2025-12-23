<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ImagingStudy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'abbreviation',
        'type',
        'body_part',
        'description',
        'usage_count',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'usage_count' => 'integer',
    ];

    // ==================== Relationships ====================

    public function visits(): BelongsToMany
    {
        return $this->belongsToMany(Visit::class, 'visit_imaging_studies')
            ->withPivot(['findings', 'impression', 'study_date', 'radiologist', 'notes'])
            ->withTimestamps();
    }

    // ==================== Scopes ====================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeMostUsed($query, $limit = 20)
    {
        return $query->orderBy('usage_count', 'desc')->limit($limit);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByBodyPart($query, $bodyPart)
    {
        return $query->where('body_part', $bodyPart);
    }

    // ==================== Helpers ====================

    public function incrementUsage(): void
    {
        $this->increment('usage_count');
    }

    public function getFullNameAttribute(): string
    {
        $name = $this->name_ar;

        if ($this->body_part) {
            $name .= " - {$this->body_part}";
        }

        return $name;
    }

    public function getTypeNameAttribute(): string
    {
        return match ($this->type) {
            'x-ray' => 'أشعة عادية',
            'ct' => 'أشعة مقطعية',
            'mri' => 'رنين مغناطيسي',
            'ultrasound' => 'إيكو/سونار',
            'doppler' => 'دوبلر',
            'mammogram' => 'ماموجرام',
            'fluoroscopy' => 'فلوروسكوبي',
            default => 'أخرى',
        };
    }
}
