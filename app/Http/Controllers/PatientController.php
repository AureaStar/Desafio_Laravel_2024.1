<?php

namespace App\Http\Controllers;

use App\Models\{Patient, User, Health_plan};
use Illuminate\Http\Request;
use App\Http\Requests\{PatientRequest, UserRequest};

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('user_type', 'patient')->paginate(8);

        $health_plans = Health_plan::all();

        return view('management', [
            'users' => $users, 
            'table' => 'patients', 
            'health_plans' => $health_plans
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->authorize('create', Patient::class);

        $user = $this->storeUser($request);

        $this->storePatient($request, $user);

        return redirect()
            ->back()
            ->with('success', 'Patient created successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeUser (UserRequest $request) {

        $validatedData = $request->validated();

        $user = User::create($validatedData, [
                'password' => bcrypt($validatedData['password']),
                'user_type' => 'patient',
            ]
        );

        return $user;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storePatient (PatientRequest $request, User $user) {

        $validatedData = $request->validated();

        $patient = Patient::create($validatedData, [
                'user_id' => $user->id,
                'health_plan_id' => $request->health_plan_id,
                'image' => isset($validatedData['image']) ? $validatedData['image'] : 'assets/patient.png',
                'registration_status' => 'complete',
            ]
        );

        return $patient;
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        $user = $patient->user;

        return view('patients_management', [
            'patient' => $patient, 
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $this->authorize('update', $patient);

        $this->updateUser($request, $patient);

        $this->updatePatient($request, $patient);

        return redirect()
            ->route('patients.index')
            ->with('success', 'Patient updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePatient (PatientRequest $request, Patient $patient) {

        $validatedData = $request->validated();

        $patient->update($validatedData, [
                'health_plan_id' => $request->health_plan_id,
                'image' => isset($validatedData['image']) ? $validatedData['image'] : 'assets/patient.png',
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateUser (UserRequest $request, Patient $patient) {

        $validatedData = $request->validated();

        $patient->user->update($validatedData, [
                'password' => bcrypt($validatedData['password']),
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()
            ->route('patients.index')
            ->with('success', 'Patient deleted successfully.');
    }

    public function appointments(Patient $patient)
    {
        $user = $patient->user;

        return view('appointments', [
            'user' => $user, 
            'appointments' => $patient->appointments
        ]);
    }
}
