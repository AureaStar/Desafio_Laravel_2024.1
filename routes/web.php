<?php

use App\Http\Controllers\{AdminController, AppointmentController, DoctorController, HealthPlanController, PatientController, PatientProfileController, ProfileController, SpecialtyController, DoctorProfileController};
use App\Models\Appointment;
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('', function () {
        if (auth()->user()->user_type === 'admin') {
            return redirect(route('admin.index'));
        }
        elseif (auth()->user()->user_type === 'doctor') {
            return redirect(route('doctor.appointments'));
        }
        elseif (auth()->user()->user_type === 'patient') {
            return redirect(route('patients.appointments.index'));
        }
    });

    Route::get('/dashboard/doctors', [DoctorController::class, 'dashboard'])
        ->name('dashboard.doctors');

    Route::get('/dashboard/patients', [PatientController::class, 'dashboard'])
        ->name('dashboard.patients');
});

Route::middleware('auth')->group(function () {

    
});

// Rotas de Médicos

Route::middleware(['auth', 'verified', 'doctor'])->group(function () {

    Route::get('/doctor', function () {
        return redirect(route('doctor.appointments'));
    });

    Route::get('/doctor/profile', [DoctorProfileController::class, 'view'])
       ->name('doctor.profile');

    Route::get('/doctor/profile/edit', [DoctorProfileController::class, 'edit'])
       ->name('doctor.edit');

    Route::patch('/doctor/profile', [DoctorProfileController::class, 'update'])
       ->name('doctor.update');

    Route::get('/doctor/appointments', [DoctorController::class, 'appointments'])
        ->name('doctor.appointments');

    Route::get('/appointments/report', [AppointmentController::class, 'report'])
        ->name('appointments.report');
});

// Rotas de Pacientes

Route::middleware(['auth', 'verified', 'patient'])->group(function () {

    Route::get('/patient', function () {
        return redirect(route('patients.appointments.index'));
    });

    Route::get('/patient/profile', [PatientProfileController::class, 'view'])
        ->name('patient.profile');

    Route::get('/patient/profile/edit', [PatientProfileController::class, 'edit'])
        ->name('patient.edit');

    Route::patch('/patient/profile', [PatientProfileController::class, 'update'])
        ->name('patient.update');

    Route::get('/patients/appointments/view', [PatientController::class, 'appointments'])
        ->name('patients.appointments');

    Route::post('/appointments/create', [AppointmentController::class, 'create'])
        ->name('patients.appointments.create');

    Route::resource('/patients/appointments', AppointmentController::class)
        ->only(['index', 'store', 'destroy'])->names([
            'index' => 'patients.appointments.index',
            'store' => 'patients.appointments.store',
            'destroy' => 'patients.appointments.destroy',
        ]);
});

// Rotas Administrativas

Route::middleware(['auth', 'verified', 'admin'])->group(function () {

    Route::get('/admin', [AdminController::class, 'view'])
        ->name('admin.index');

    Route::resource('/admin/appointments', AppointmentController::class);
    Route::resource('/admin/doctors', DoctorController::class);
    Route::resource('/admin/patients', PatientController::class);
    Route::resource('/admin/specialties', SpecialtyController::class);
    Route::resource('/admin/health_plans', HealthPlanController::class);
});

require __DIR__ . '/auth.php';
