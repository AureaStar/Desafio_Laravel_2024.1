<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use App\Models\Health_plan;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('user_type', 'patient')->paginate(8);
        $health_plans = Health_plan::all();

        return view('management', ['users' => $users, 'table' => 'patients', 'health_plans' => $health_plans]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients_management');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {

        $this->authorize('create', Patient::class);

        $validatedData = $request->validated();

        // Criar o usuário
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'user_type' => 'patient',
        ]);

        // Criar o paciente
        $patient = Patient::create([
            'user_id' => $user->id,
            'address' => $validatedData['address'],
            'phone' => $validatedData['phone'],
            'health_plan_id' => $request->health_plan_id,
            'birth_date' => $validatedData['birth_date'],
            'cpf' => $validatedData['cpf'],
            'image' => isset($validatedData['image']) ? $validatedData['image'] : 'assets/patient.png',
            'blood_type' => $validatedData['blood_type'],
            'registration_status' => 'complete',
        ]);

        return redirect()->back()->with('success', 'Patient created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        $user = $patient->user;

        return view('patients_management', ['patient' => $patient, 'user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        $user = $patient->user;

        return view('patients_management/edit_patient', ['patient' => $patient, 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $patient->update($request->validated());

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }

    public function appointments(Patient $patient)
    {
        $user = $patient->user;

        return view('appointments', ['user' => $user, 'appointments' => $patient->appointments]);
    }
}
