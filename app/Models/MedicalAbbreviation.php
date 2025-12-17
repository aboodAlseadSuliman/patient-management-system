<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalAbbreviation extends Model
{
    use HasFactory;

    protected $fillable = [
        'abbreviation',
        'full_text',
        'category',
        'language',
        'usage_count',
        'created_by',
        'is_system',
        'is_active',
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'is_active' => 'boolean',
        'usage_count' => 'integer',
    ];

    // ==================== Relationships ====================

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ==================== Scopes ====================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSearchAbbreviation($query, $search)
    {
        return $query->where('abbreviation', 'like', "{$search}%")
            ->orWhere('full_text', 'like', "%{$search}%");
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

    public static function expand(string $text): string
    {
        $abbreviations = self::active()->get();

        foreach ($abbreviations as $abbr) {
            $text = str_replace($abbr->abbreviation, $abbr->full_text, $text);
        }

        return $text;
    }
}
