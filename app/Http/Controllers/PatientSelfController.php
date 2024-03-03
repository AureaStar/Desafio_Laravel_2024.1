<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Health_plan;
use App\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class PatientSelfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        return view('patient/dashboard', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $health_plans = Health_plan::all();

        $user = $request->user();

        return view('patient/complete_registration', [
            'user' => $user,
            'health_plans' => $health_plans,
        ]);
    }

    /**
     * Update the specified resource in storage.
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
}
