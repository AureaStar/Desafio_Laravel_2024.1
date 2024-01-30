<?php

namespace App\Http\Controllers;

use App\Models\{Doctor, User, Specialty};
use App\Http\Requests\{DoctorRequest, UserRequest};
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('user_type', 'doctor')->paginate(8);

        $specialties = Specialty::all();

        return view('management', [
            'users' => $users,
            'table' => 'doctors',
            'specialties' => $specialties
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->authorize('create', Doctor::class);

        $user = $this->storeUser($request);

        $this->storeDoctor($request, $user);

        return redirect()
            ->back()
            ->with('success', 'Doctor created successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeUser (UserRequest $request) {

        $validatedData = $request->validated();

        $user = User::create($validatedData, [
                'password' => bcrypt($validatedData['password']),
                'user_type' => 'doctor',
            ]
        );

        return $user;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeDoctor (DoctorRequest $request, User $user) {

        $validatedData = $request->validated();

        $doctor = Doctor::create($validatedData, [
                'user_id' => $user->id,
                'specialty_id' => $request->specialty,
                'image' => isset($validatedData['image']) ? $validatedData['image'] : 'assets/doctor.png',
            ]
        );

        return $doctor;
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        $user = $doctor->user;

        return view('doctors_management', [
            'doctor' => $doctor, 
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {

        $this->updateUser($request, $doctor);

        $this->updateDoctor($request, $doctor);

        return redirect()
            ->route('doctors.index')
            ->with('success', 'Doctor updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateDoctor(DoctorRequest $request, Doctor $doctor)
    {
        $doctor->update($request->validated(), [
                'specialty_id' => $request->specialty,
                'image' => isset($validatedData['image']) ? $validatedData['image'] : 'assets/doctor.png',
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */ 
    public function updateUser(UserRequest $request, Doctor $doctor)
    {

        $doctor->user->update($request->validated(), [
                'password' => bcrypt($request->validated()['password']),
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        $doctor->user->delete();

        return redirect()
            ->route('doctors.index')
            ->with('success', 'Doctor deleted successfully.');
    }

    
    public function appointments()
    {
        $user = auth()->user();
        $appointments = $user->doctor->appointments()->paginate(8);

        return view('appointments', [
            'appointments' => $appointments, 
            'table' => 'doctors', 
            'user' => $user
        ]);
    }
}
