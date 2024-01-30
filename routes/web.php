<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\HealthPlanController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect(route('dashboard'));
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/dashboard/doctors', [DoctorController::class, 'dashboard'])
        ->name('dashboard.doctors');

    Route::get('/dashboard/patients', [PatientController::class, 'dashboard'])
        ->name('dashboard.patients');

});

Route::middleware('auth')->group(function () {

    // Rotas de Perfil

    Route::get('/profile', [ProfileController::class, 'view'])
        ->name('profile.view');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Rotas de Consultas

    Route::get('/doctors/appointments', [DoctorController::class, 'appointments'])
        ->name('doctors.appointments');

    Route::get('/appointments/report', [AppointmentController::class, 'report'])
        ->name('appointments.report');

    Route::get('/patients/appointments', [PatientController::class, 'appointments'])
        ->name('patients.appointments');

});

// Rotas Administrativas

Route::middleware(['auth', 'verified', 'admin'])->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.index');

    Route::resource('/admin/appointments', AppointmentController::class);
    Route::resource('/admin/doctors', DoctorController::class);
    Route::resource('/admin/patients', PatientController::class);
    Route::resource('/admin/specialties', SpecialtyController::class);
    Route::resource('/admin/health_plans', HealthPlanController::class);
});

require __DIR__.'/auth.php';
