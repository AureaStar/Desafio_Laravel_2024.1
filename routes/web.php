<?php

use App\Http\Controllers\{AdminController, AppointmentController, DoctorController, HealthPlanController, PatientController, PatientProfileController, ProfileController, SpecialtyController, DoctorProfileController, PatientSelfController};
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

Route::get('', function () {
    return redirect(route('home'));
});


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', function () {
        if (auth()->user()->user_type === 'admin') {
            return redirect(route('admin.index'));
        }
        elseif (auth()->user()->user_type === 'doctor') {
            return redirect(route('doctor.appointments'));
        }
        elseif (auth()->user()->user_type === 'patient' && auth()->user()->patient->registration_status === 'complete') {
            return redirect(route('patients.appointments.index'));
        }
        elseif (auth()->user()->user_type === 'patient' && auth()->user()->patient->registration_status === 'incomplete') {
            return redirect('/dashboard/patient');
        };
    })
        ->name('home');

    Route::get('/dashboard/doctors', [DoctorController::class, 'dashboard'])
        ->name('dashboard.doctors');
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

    Route::delete('/doctor/profile', [DoctorProfileController::class, 'destroy'])
         ->name('doctor.destroy');

    Route::get('/doctor/appointments', [DoctorController::class, 'appointments'])
        ->name('doctor.appointments');

    Route::get('/appointments/report', [AppointmentController::class, 'report'])
        ->name('appointments.report');

});

// Rotas de Pacientes

Route::middleware(['auth', 'verified', 'patient', 'incomplete'])->group(function () {

    Route::get('/dashboard/patient', [PatientSelfController::class, 'index'])
        ->name('patient.index');

    Route::get('/patient/complete', [PatientSelfController::class, 'edit'])
        ->name('patient.complete');

    Route::patch('/patient/completed', [PatientSelfController::class, 'update'])
        ->name('patient.completed');

});

Route::middleware(['auth', 'verified', 'patient', 'completed'])->group(function () {

    Route::get('/patient', function () {
        return redirect(route('patients.appointments.index'));
    });

    Route::get('/patient/profile', [PatientProfileController::class, 'view'])
        ->name('patient.profile');

    Route::get('/patient/profile/edit', [PatientProfileController::class, 'edit'])
        ->name('patient.edit');

    Route::patch('/patient/profile', [PatientProfileController::class, 'update'])
        ->name('patient.update');

    Route::delete('/patient/profile', [PatientProfileController::class, 'destroy'])
        ->name('patient.destroy');

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

    Route::post('/admin/send_email', [AdminController::class, 'sendEmail'])
        ->name('admin.send_email');
});

require __DIR__ . '/auth.php';
