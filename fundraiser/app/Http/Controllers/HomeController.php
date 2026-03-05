<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Story;

class HomeController extends Controller
{
    public function index()
    {
        $stories = Story::latest()
            ->take(6)
            ->get();

        return view('welcome', compact('stories'));
    }
}
