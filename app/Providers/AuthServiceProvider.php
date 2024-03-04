<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\{Appointment, Doctor, Health_plan, Patient, Specialty};
use App\Policies\{AppointmentPolicy, DoctorPolicy, Health_planPolicy, PatientPolicy, SpecialtyPolicy};
use Illuminate\Support\Facades\Gate;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;

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
        Specialty::class => SpecialtyPolicy::class,
        Health_plan::class => Health_planPolicy::class,
        Appointment::class => AppointmentPolicy::class,
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
