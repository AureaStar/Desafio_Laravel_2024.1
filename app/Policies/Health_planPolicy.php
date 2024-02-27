<?php

namespace App\Policies;

use App\Models\Health_plan;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Auth\Access\Response;

class Health_planPolicy
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
    public function view(User $user, Health_plan $healthPlan, Patient $patient): bool
    {
        return $user->user_type === 'admin' || ($user->user_type === 'patient' && $patient->health_plan_id === $healthPlan->id);
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
    public function update(User $user, Health_plan $healthPlan): bool
    {
        return $user->user_type === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Health_plan $healthPlan): bool
    {
        return $user->user_type === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(User $user, Health_plan $healthPlan): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can permanently delete the model.
     */
    // public function forceDelete(User $user, Health_plan $healthPlan): bool
    // {
    //     //
    // }
}
