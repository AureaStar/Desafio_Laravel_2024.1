<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Health_plan;

class ProfileController extends Controller
{

    public function view()
    {
        $user = Auth::user();
        $doctors_qtd = Doctor::all()->count();
        $patients_qtd = Patient::all()->count();
        $type = $user->user_type;

        return view('profile', ['user' => $user, 'doctors_qtd' => $doctors_qtd, 'patients_qtd' => $patients_qtd, 'type' => $type]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $health_plans = Health_plan::all();
        return view('profile.edit', [
            'user' => $request->user(),
            'health_plans' => $health_plans
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
        $user->user_type = 'patient';

        $user->save();

        $patient = Patient::where('user_id', $user->id)->first();

        $patient->address = $validatedData['address'];
        $patient->phone = $validatedData['phone'];
        $patient->health_plan_id = $request->health_plan_id;
        $patient->birth_date = $validatedData['birth_date'];
        $patient->cpf = $validatedData['cpf'];
        $image = $request->file('image');
        if (isset($image)) {
            $patch = $image->store('public/assets/images');
            $newpatch = Str::replaceFirst('public', 'storage', $patch);
            $patient->image = isset($newpatch) ? $newpatch : 'assets/patient.png';
        }
        $patient->blood_type = $validatedData['blood_type'];
        $patient->registration_status = 'complete';

        $patient->save();

        return Redirect::route('dashboard')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
