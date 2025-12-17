<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;

class PatientPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Admin و Doctor يستطيعون رؤية المرضى
        return $user->isDoctorOrAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Patient $patient): bool
    {
        // Admin يرى الكل
        if ($user->isAdmin()) {
            return true;
        }

        // Doctor يرى مرضاه فقط
        if ($user->isDoctor()) {
            return $patient->created_by === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Admin و Doctor يستطيعون إضافة مرضى
        return $user->isDoctorOrAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Patient $patient): bool
    {
        // Admin يعدل الكل
        if ($user->isAdmin()) {
            return true;
        }

        // Doctor يعدل مرضاه فقط
        if ($user->isDoctor()) {
            return $patient->created_by === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Patient $patient): bool
    {
        // Admin فقط يستطيع الحذف
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Patient $patient): bool
    {
        // Admin فقط
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Patient $patient): bool
    {
        // Admin فقط
        return $user->isAdmin();
    }
}
