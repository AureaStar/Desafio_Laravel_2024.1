<?php

namespace App\Policies;

use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SpecialtyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->user_type === 'admin';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Specialty $specialty, Doctor $doctor): bool
    {
        return $user->user_type === 'admin' || ($user->id === $doctor->user_id && $doctor->specialty_id === $specialty->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->user_type === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Specialty $specialty): bool
    {
        return $user->user_type === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Specialty $specialty): bool
    {
        return $user->user_type === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(User $user, Specialty $specialty): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can permanently delete the model.
     */
    // public function forceDelete(User $user, Specialty $specialty): bool
    // {
    //     //
    // }
}
