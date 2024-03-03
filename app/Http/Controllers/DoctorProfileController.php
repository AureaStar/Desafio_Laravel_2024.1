<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Support\Facades\{Auth, Redirect};
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Models\{Doctor, Patient, Health_plan, Specialty};

class DoctorProfileController extends Controller
{

    public function view()
    {
        $user = Auth::user();

        return view('doctor/profile', [
            'user' => $user, 
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $specialties = Specialty::all();

        $user = $request->user();

        return view('doctor/edit', [
            'user' => $user,
            'specialties' => $specialties,
        ]);
    }

     /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $user = $request->user();

        $user->name = $validatedData['name'];
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->user_type = 'doctor';

        $user->save();

        $doctor = Doctor::where('user_id', $user->id)->first();

        $doctor->address = $validatedData['address'];
        $doctor->phone = $validatedData['phone'];
        $doctor->birth_date = $validatedData['birth_date'];
        $doctor->cpf = $validatedData['cpf'];
        $image = $request->file('image');
        if (isset($image)) {
            $patch = $image->store('public/assets/images');
            $newpatch = Str::replaceFirst('public', 'storage', $patch);
            $doctor->image = isset($newpatch) ? $newpatch : 'assets/doctor.png';
        }

        $doctor->save();

        return Redirect::route('doctor.profile')->with('success', 'Perfil atualizado com sucesso.');
    }

    public function destroy(Request $request)
    {
        $user = $request->user();
        $doctor = $user->doctor;

        if ($doctor->appointments->count() > 0) {
            return Redirect::route('doctor.profile')->with('error', 'Esta conta não pode ser deletada pois possui consultas marcadas.');
        }

        $doctor->delete();
        $user->delete();

        return Redirect::route('home');
    }
}