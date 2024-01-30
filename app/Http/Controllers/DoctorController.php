<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Specialty;
use Illuminate\Support\Facades\Log;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('user_type', 'doctor')->paginate(8);
        $specialties = Specialty::all();

        return view('management', ['users' => $users, 'table' => 'doctors', 'specialties' => $specialties]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('doctors.store');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctorRequest $request)
    {

        $this->authorize('create', Doctor::class);
    
        $validatedData = $request->validated();
    

        // Criar o usuário
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'user_type' => 'doctor',
        ]);

        // Criar o médico
        $doctor = Doctor::create([
            'user_id' => $user->id,
            'address' => $validatedData['address'],
            'phone' => $validatedData['phone'],
            'specialty_id' => $request->specialty,
            'work_period' => $validatedData['work_period'], // 'morning', 'afternoon', 'night', 'dawn'
            'crm' => $validatedData['crm'],
            'image' => isset($validatedData['image']) ? $validatedData['image'] : 'assets/doctor.png',
            'birth_date' => $validatedData['birth_date'],
            'cpf' => $validatedData['cpf'],
        ]);

        return redirect()->back()->with('success', 'Doctor created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        $user = $doctor->user;

        return view('doctors_management', ['doctor' => $doctor, 'user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        $user = $doctor->user;

        return view('doctors_management/edit_doctor', ['doctor' => $doctor, 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        $doctor->update($request->validated());

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        $doctor->user->delete();

        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
    }

    
    public function appointments()
    {
        $user = auth()->user();
        $appointments = $user->doctor->appointments()->paginate(8);

        return view('appointments', ['appointments' => $appointments, 'table' => 'doctors', 'user' => $user]);
    }
}
