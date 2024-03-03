<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Doctor;
use App\Models\Patient;
use App\Policies\PatientPolicy;
use App\Policies\DoctorPolicy;
use Illuminate\Support\Facades\Gate;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Patient::class => PatientPolicy::class,
        Doctor::class => DoctorPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('admin', function ($user) {
            return $user->user_type === 'admin';
        });

        Gate::define('doctor', function ($user) {
            return $user->user_type === 'doctor';
        });

        Gate::define('patient', function ($user) {
            return $user->user_type === 'patient';
        });

        Gate::define('completed', function ($user) {
            return $user->user_type === 'patient' && $user->patient->registration_status === 'complete';
        });

        Gate::define('incomplete', function($user) {
            return $user->user_type === 'patient' && $user->patient->registration_status === 'incomplete';
        });
    }
}
