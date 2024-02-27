<?php

namespace App\Http\Controllers;

use App\Models\{Doctor, Patient, Appointment, Specialty, Health_plan};

class AdminController extends Controller
{
    public function view () {
        $user = auth()->user();
        $doctors_qtd = Doctor::all()->count();
        $patients_qtd = Patient::all()->count();
        $appointments_qtd = Appointment::all()->count();
        $specialties_qtd = Specialty::all()->count();
        $health_plans_qtd = Health_plan::all()->count();
        return view('admin/dashboard', ['user' => $user, 'doctors_qtd' => $doctors_qtd, 'patients_qtd' => $patients_qtd, 'appointments_qtd' => $appointments_qtd, 'specialties_qtd' => $specialties_qtd, 'health_plans_qtd' => $health_plans_qtd]);
    }
}