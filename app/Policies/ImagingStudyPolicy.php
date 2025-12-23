<?php

namespace App\Policies;

use App\Models\ImagingStudy;
use App\Models\User;

class ImagingStudyPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ImagingStudy $imagingStudy): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, ImagingStudy $imagingStudy): bool
    {
        return true;
    }

    public function delete(User $user, ImagingStudy $imagingStudy): bool
    {
        return true;
    }

    public function restore(User $user, ImagingStudy $imagingStudy): bool
    {
        return true;
    }

    public function forceDelete(User $user, ImagingStudy $imagingStudy): bool
    {
        return true;
    }
}
