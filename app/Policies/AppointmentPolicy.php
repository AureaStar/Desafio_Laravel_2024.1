<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AppointmentPolicy
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
    public function view(User $user, Appointment $appointment): bool
    {
        return $user->user_type === 'admin' || $user->id === $appointment->patient->user_id || $user->id === $appointment->doctor->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Patient $patient): bool
    {
        return $user->user_type === 'admin' || $user->id === $patient->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Appointment $appointment): bool
    {
        return $user->user_type === 'admin' || $user->id === $appointment->patient->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Appointment $appointment): bool
    {
        return $user->user_type === 'admin' || $user->id === $appointment->patient->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(User $user, Appointment $appointment): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can permanently delete the model.
     */
    // public function forceDelete(User $user, Appointment $appointment): bool
    // {
    //     //
    // }
}
