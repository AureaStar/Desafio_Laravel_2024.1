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

Route::get('/dashboard', [AdminController::class, 'view'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/admin/profile', [ProfileController::class, 'view'])->name('profile.view');
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin/doctors/{doctor}/appointments', [DoctorController::class, 'appointments'])->name('doctors.appointments');

    Route::get('/admin/patients/{patient}/appointments', [PatientController::class, 'appointments'])->name('patients.appointments');

    Route::get('/admin/specialties/{specialty}/appointments', [SpecialtyController::class, 'appointments'])->name('specialties.appointments');
    Route::get('/admin/specialties/{specialty}/doctors', [SpecialtyController::class, 'doctors'])->name('specialties.doctors');

    Route::get('/admin/health_plans/{health_plan}/appointments', [HealthPlanController::class, 'appointments'])->name('health_plans.appointments');
    Route::get('/admin/health_plans/{health_plan}/patients', [HealthPlanController::class, 'patients'])->name('health_plans.patients');

    Route::resource('/admin/appointments', AppointmentController::class);
    Route::resource('/admin/doctors', DoctorController::class);
    Route::resource('/admin/patients', PatientController::class);
    Route::resource('/admin/specialties', SpecialtyController::class);
    Route::resource('/admin/health_plans', HealthPlanController::class);

});

require __DIR__.'/auth.php';
