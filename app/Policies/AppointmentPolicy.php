<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Appointment $appointment): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Appointment $appointment): bool
    {
        return true;
    }

    public function delete(User $user, Appointment $appointment): bool
    {
        // يمكن حذف المواعيد المجدولة والملغية فقط
        return in_array($appointment->status, ['scheduled', 'cancelled', 'rescheduled']);
    }

    public function restore(User $user, Appointment $appointment): bool
    {
        return true;
    }

    public function forceDelete(User $user, Appointment $appointment): bool
    {
        return true;
    }
}
