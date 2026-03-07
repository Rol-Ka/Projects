<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $query = Story::with('user');

        // PAIEŠKA
        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($u) use ($request) {
                        $u->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // STATUS FILTRAS
        if ($request->status === 'pending') {
            $query->where('is_approved', false);
        }

        if ($request->status === 'approved') {
            $query->where('is_approved', true);
        }

        if ($request->status === 'completed') {
            $query->whereColumn('current_amount', '>=', 'goal_amount');
        }

        // RŪŠIAVIMAS
        switch ($request->sort) {

            case 'created_asc':
                $query->orderBy('created_at', 'asc');
                break;


            default:
                $query->orderBy('created_at', 'desc');
        }

        $stories = $query->get();

        if ($request->ajax()) {
            return view('admin.partials.stories-list', compact('stories'))->render();
        }

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

    public function dashboard()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('admin.dashboard');
    }
}
