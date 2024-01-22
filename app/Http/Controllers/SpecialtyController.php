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
}
