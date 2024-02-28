<?php

namespace App\Http\Controllers;

use App\Models\{Doctor, User, Specialty};
use App\Http\Requests\{DoctorRequest, UpdateDoctorRequest, UserRequest};
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

        return view('admin/doctors', [
            'users' => $users,
            'table' => 'doctors',
            'specialties' => $specialties
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoctorRequest $request)
    {
        $this->authorize('create', Doctor::class);

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
            'user_type' => 'doctor',
        ]);

        // Criar o médico
        $doctor = Doctor::create([
            'user_id' => $user->id,
            'address' => $validatedData['address'],
            'birth_date' => $validatedData['birth_date'],
            'cpf' => $validatedData['cpf'],
            'crm' => $validatedData['crm'],
            'phone' => $validatedData['phone'],
            'specialty_id' => $validatedData['specialty'],
            'image' => isset($validatedData['image']) ? $validatedData['image'] : 'assets/doctor.png',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Doctor created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        $this->authorize('update', $doctor);

        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension(); // Gera um nome único para o arquivo
            $imagePath = 'storage/' . $request->file('image')->storeAs('assets/images', $imageName, 'public');
            $validatedData['image'] = $imagePath;
        }

        $user = $doctor->user;

        $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => ($validatedData['password'] ? bcrypt($validatedData['password']) : $user->password),
            ]
        );

        $doctor->update([
                'address' => $validatedData['address'],
                'phone' => $validatedData['phone'],
                'birth_date' => $validatedData['birth_date'],
                'crm' => $validatedData['crm'],
                'work_period' => $validatedData['work_period'], // 'work_period' => 'morning', 'afternoon', 'night', 'dawn
                'cpf' => $validatedData['cpf'],
                'specialty_id' => $request->specialty,
                'image' => isset($validatedData['image']) ? $validatedData['image'] : 'assets/doctor.png',
            ]
        );

        return redirect()
            ->route('doctors.index')
            ->with('success', 'Doctor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $this->authorize('delete', $doctor);

        $user = $doctor->user;
        $doctor->delete();
        $user->delete();

        return redirect()
            ->route('doctors.index')
            ->with('success', 'Doctor deleted successfully.');
    }

    
    public function appointments()
    {
        $user = auth()->user();
        $appointments = $user->doctor->appointments()->paginate(8);

        return view('doctor/appointments', [
            'appointments' => $appointments, 
            'table' => 'doctors', 
            'user' => $user
        ]);
    }
}
