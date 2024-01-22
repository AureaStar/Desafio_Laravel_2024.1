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
}
