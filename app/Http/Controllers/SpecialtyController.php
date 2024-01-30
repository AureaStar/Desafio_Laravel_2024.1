<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Specialty;

class SpecialtyController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index() {
        $specialties = Specialty::paginate(8);

        return view('management', ['specialties' => $specialties, 'table' => 'specialties']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $formattedValue = preg_replace('/[^\d,]/', '', $request->input('value'));
        $numericValue = str_replace(',', '.', $formattedValue);
        $request->merge(['value' => $numericValue]);
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'value' => 'required|numeric',
        ]);

        $specialty = Specialty::create($validatedData);

        return redirect()->route('specialties.index')->with('success', 'Especialidade criada com sucesso!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Specialty $specialty) {
        $formattedValue = preg_replace('/[^\d,]/', '', $request->input('value'));
        $numericValue = str_replace(',', '.', $formattedValue);
        $request->merge(['value' => $numericValue]);
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'value' => 'required|numeric',
        ]);

        $specialty->update($validatedData);

        return redirect()->route('specialties.index')->with('success', 'Especialidade atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialty $specialty) {
        $doctors = $specialty->doctors;
        if ($doctors->count() > 0) {
            return redirect()->route('specialties.index')->with('error', 'Não é possível deletar uma especialidade que possui médicos vinculados!');
        }
        $specialty->delete();

        return redirect()->route('specialties.index')->with('success', 'Especialidade deletada com sucesso!');
    }

}
