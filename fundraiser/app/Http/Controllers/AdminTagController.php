<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class AdminTagController extends Controller
{

    public function index(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $query = Tag::withCount('stories');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $tags = $query
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.tags', compact('tags'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:tags,name'
        ]);

        Tag::create([
            'name' => $request->name
        ]);

        return back();
    }


    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:tags,name,' . $tag->id
        ]);

        $tag->update([
            'name' => $request->name
        ]);

        return back();
    }


    public function destroy(Tag $tag)
    {
        $tag->delete();

        return back();
    }
}
