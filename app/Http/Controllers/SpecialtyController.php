<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use App\Http\Requests\SpecialtyRequest;

class SpecialtyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        
        $specialties = Specialty::paginate(8);

        return view('admin/specialties', ['specialties' => $specialties, 'table' => 'specialties']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SpecialtyRequest $request) {

        $request['value'] = floatval($request['value']);

        $validatedData = $request->validated();

        Specialty::create($validatedData);

        return redirect()
            ->route('specialties.index')
            ->with('success', 'Especialidade criada com sucesso!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SpecialtyRequest $request, Specialty $specialty) {

        $validatedData = $request->validated();

        $specialty->update($validatedData);

        return redirect()
            ->route('specialties.index')
            ->with('success', 'Especialidade atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialty $specialty) {

        $doctors = $specialty->doctors;

        if ($doctors->count() > 0) {
            return redirect()
                ->route('specialties.index')
                ->with('error', 'Não é possível deletar uma especialidade que possui médicos vinculados!');
        }

        $specialty->delete();

        return redirect()
            ->route('specialties.index')
            ->with('success', 'Especialidade deletada com sucesso!');
    }

}
