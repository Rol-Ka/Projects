<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Farm;

class FarmController extends Controller
{
    public function read()
    {
        $animals = Farm::all();
        $animals = $animals->sortBy('weight');

        $weightSum = $animals->sum('weight');

        return view('farm.read', ['animals' => $animals, 'weightSum' => $weightSum]);
    }
}
