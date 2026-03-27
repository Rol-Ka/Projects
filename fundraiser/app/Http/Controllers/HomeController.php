<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;

class HomeController extends Controller
{
    public function index()
    {

        $activeStories = Story::where('is_approved', true)
            ->where('is_completed', false)
            ->latest()
            ->take(4)
            ->get();


        $completedStories = Story::where('is_approved', true)
            ->where('is_completed', true)
            ->latest()
            ->take(4)
            ->get();

        return view('welcome', compact('activeStories', 'completedStories'));
    }
}
