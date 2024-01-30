<?php

namespace App\Http\Controllers;

use App\Models\{Doctor, Patient};

class AdminController extends Controller
{
    public function view () {
        $user = auth()->user();
        $doctors_qtd = Doctor::all()->count();
        $patients_qtd = Patient::all()->count();
        return view('management', ['user' => $user, 'doctors_qtd' => $doctors_qtd, 'patients_qtd' => $patients_qtd, 'table' => 'dashboard']);
    }
}