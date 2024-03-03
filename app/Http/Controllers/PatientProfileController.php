<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Support\Facades\{Auth, Redirect};
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Models\{Doctor, Patient, Health_plan, Specialty};

class PatientProfileController extends Controller
{

    public function view()
    {
        $user = Auth::user();

        return view('patient/profile', [
            'user' => $user, 
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $health_plans = Health_plan::all();

        $user = $request->user();

        return view('patient/edit', [
            'user' => $user,
            'health_plans' => $health_plans,
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

        return Redirect::route('patient.profile')->with('status', 'profile-updated');
    }

    public function destroy(Request $request)
    {
        $user = $request->user();
        $patient = $user->patient;
        $patient->delete();
        $user->delete();

        return redirect()
            ->route('home');
    }
}