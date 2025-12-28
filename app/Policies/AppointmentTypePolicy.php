<?php

namespace App\Policies;

use App\Models\AppointmentType;
use App\Models\User;

class AppointmentTypePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, AppointmentType $appointmentType): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, AppointmentType $appointmentType): bool
    {
        return true;
    }

    public function delete(User $user, AppointmentType $appointmentType): bool
    {
        // منع الحذف إذا كانت هناك مواعيد مرتبطة
        return $appointmentType->appointments()->count() === 0;
    }

    public function restore(User $user, AppointmentType $appointmentType): bool
    {
        return true;
    }

    public function forceDelete(User $user, AppointmentType $appointmentType): bool
    {
        return $appointmentType->appointments()->count() === 0;
    }
}
