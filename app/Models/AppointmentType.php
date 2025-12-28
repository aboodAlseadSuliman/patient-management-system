<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class AppointmentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'slug',
        'description',
        'color',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ==================== Relationships ====================

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    // ==================== Scopes ====================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('name_ar');
    }

    // ==================== Helpers ====================

    public static function getDropdownOptions(): array
    {
        return static::active()
            ->ordered()
            ->pluck('name_ar', 'id')
            ->toArray();
    }

    // ==================== Boot ====================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($type) {
            if (empty($type->slug)) {
                $type->slug = Str::slug($type->name_en ?? $type->name_ar);
            }
        });

        static::updating(function ($type) {
            if (empty($type->slug)) {
                $type->slug = Str::slug($type->name_en ?? $type->name_ar);
            }
        });
    }
}
