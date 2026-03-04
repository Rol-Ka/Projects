<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;

class AdminController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $stories = Story::with('user')->get();

        return view('admin.stories', compact('stories'));
    }


    public function approve(Story $story)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $story->update([
            'is_approved' => true,
            'approved_at' => now()
        ]);

        return back();
    }


    public function destroy(Story $story)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $story->delete();

        return back();
    }
}
