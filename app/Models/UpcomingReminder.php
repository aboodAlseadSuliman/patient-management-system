<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UpcomingReminder extends Model
{
    /**
     * The table associated with the model.
     * This is actually a database view, not a real table.
     */
    protected $table = 'upcoming_reminders_view';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'reminder_id';

    /**
     * The "type" of the primary key ID.
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     */
    public $incrementing = false;

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'reminder_date' => 'date',
        'expected_result_date' => 'date',
        'calculated_followup_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the patient that owns the reminder.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the visit that owns the reminder.
     */
    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }

    /**
     * Scope a query to only include upcoming reminders within specified days.
     */
    public function scopeUpcoming($query, int $days = 30)
    {
        return $query->where('reminder_date', '<=', now()->addDays($days));
    }

    /**
     * Scope a query to only include overdue reminders.
     */
    public function scopeOverdue($query)
    {
        return $query->where('reminder_date', '<', now());
    }

    /**
     * Scope a query to only include reminders for a specific type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('reminder_type', $type);
    }
}
