<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailToPatient;
use App\Jobs\MailJob;
use App\Models\{Doctor, Patient, Appointment, Specialty, Health_plan, User};

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

    public function sendEmail (MailRequest $request) {
        $user = auth()->user();
        $validatedData = $request->validated();
        $patients = User::where('user_type', 'patient')->get();

        $email = $patients->pluck('email')->toArray();
        $subject = $validatedData['subject'];
        $message = $validatedData['message'];

        $details = [
    		'subject' => $subject,
            'message' => $message,
    	];
    	
        $job = (new MailJob($email, $message, $subject)); 

        dispatch($job);

        return redirect(route('patients.index'))->with('success', __('Email enviado com sucesso!'));
    }
}