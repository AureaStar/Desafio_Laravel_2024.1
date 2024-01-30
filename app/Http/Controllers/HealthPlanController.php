<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Health_plan;

class HealthPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $health_plans = Health_plan::paginate(8);

        return view('management', ['health_plans' => $health_plans, 'table' => 'health_plans']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $formattedValue = preg_replace('/[^\d,]/', '', $request->input('discount'));
        $numericValue = str_replace(',', '.', $formattedValue);
        $request->merge(['discount' => $numericValue]);
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'discount' => 'required',
        ]);

        $health_plan = Health_plan::create($validatedData);

        return redirect()->route('health_plans.index')->with('success', 'Plano de Saúde criado com sucesso!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Health_plan $health_plan) {
        $formattedValue = preg_replace('/[^\d,]/', '', $request->input('discount'));
        $numericValue = str_replace(',', '.', $formattedValue);
        $request->merge(['discount' => $numericValue]);
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'discount' => 'required|numeric',
        ]);

        $health_plan->update($validatedData);

        return redirect()->route('health_plans.index')->with('success', 'Plano de Saúde atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Health_plan $health_plan) {
        $patients = $health_plan->patients;
        if ($patients->count() > 0) {
            return redirect()->route('health_plans.index')->with('error', 'Não é possível excluir um plano de saúde que possui pacientes vinculados!');
        }
        $health_plan->delete();

        return redirect()->route('health_plans.index')->with('success', 'Plano de Saúde excluído com sucesso!');
    }
}
