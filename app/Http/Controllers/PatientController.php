<?php

namespace App\Http\Controllers;

use App\Models\{Patient, User, Health_plan, Specialty};
use Illuminate\Http\Request;
use App\Http\Requests\{PatientRequest, UserRequest, UpdatePatientRequest};

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('user_type', 'patient')->paginate(8);

        $health_plans = Health_plan::all();

        return view('admin/patients', [
            'users' => $users, 
            'table' => 'patients', 
            'health_plans' => $health_plans
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientRequest $request)
    {

        $this->authorize('create', Patient::class);

        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension(); // Gera um nome único para o arquivo
            $imagePath = 'storage/' . $request->file('image')->storeAs('assets/images', $imageName, 'public');
            $validatedData['image'] = $imagePath;
        }

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

        return redirect()
            ->back()
            ->with('success', 'Patient created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $this->authorize('update', $patient);

        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension(); // Gera um nome único para o arquivo
            $imagePath = 'storage/' . $request->file('image')->storeAs('assets/images', $imageName, 'public');
            $validatedData['image'] = $imagePath;
        }

        $user = $patient->user;

        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'] ? bcrypt($validatedData['password']) : $user->password,
        ]);

        $patient->update([
            'address' => $validatedData['address'],
            'phone' => $validatedData['phone'],
            'health_plan_id' => $request->health_plan_id ? $request->health_plan_id : $patient->health_plan_id,
            'birth_date' => $validatedData['birth_date'],
            'cpf' => $validatedData['cpf'],
            'image' => isset($validatedData['image']) ? $validatedData['image'] : 'assets/patient.png',
            'blood_type' => $validatedData['blood_type'],
        ]);

        return redirect()
            ->route('patients.index')
            ->with('success', 'Patient updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $this->authorize('delete', $patient);

        $user = $patient->user;
        $patient->delete();
        $user->delete();

        return redirect()
            ->route('patients.index')
            ->with('success', 'Patient deleted successfully.');
    }

    public function appointments()
    {
        $user = auth()->user();
        $patient = $user->patient;

        return view('patient/appointments', [
            'user' => $user, 
            'specialties' => Specialty::all(),
            'appointments' => $patient->appointments
        ]);
    }
}
