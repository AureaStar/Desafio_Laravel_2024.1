<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Specialty;

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
        return view('doctors_management');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctorRequest $request)
    {
        $doctor = Doctor::create($request->validated());

        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully.');
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
}
