<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    // ==================== Filament ====================

    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->role->name, ['admin', 'doctor']) && $this->is_active;
    }

    // ==================== Relationships ====================

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function createdPatients()
    {
        return $this->hasMany(Patient::class, 'created_by');
    }

    public function createdVisits()
    {
        return $this->hasMany(Visit::class, 'created_by');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    // ==================== Role Checks ====================

    public function isAdmin(): bool
    {
        return $this->role->name === 'admin';
    }

    public function isDoctor(): bool
    {
        return $this->role->name === 'doctor';
    }

    public function isDoctorOrAdmin(): bool
    {
        return in_array($this->role->name, ['admin', 'doctor']);
    }

    // ==================== Scopes ====================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDoctors($query)
    {
        return $query->whereHas('role', function ($q) {
            $q->where('name', 'doctor');
        });
    }

    public function scopeAdmins($query)
    {
        return $query->whereHas('role', function ($q) {
            $q->where('name', 'admin');
        });
    }
}
