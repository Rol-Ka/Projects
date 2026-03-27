<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;
use App\Models\StoryImage;
use App\Models\Tag;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $query = Story::with('user');

        if ($request->status === 'pending') {
            $query->where('is_approved', false);
        }

        if ($request->status === 'approved') {
            $query->where('is_approved', true)
                ->whereColumn('current_amount', '<', 'goal_amount');
        }

        if ($request->status === 'completed') {
            $query->whereNotNull('completed_at');
        }

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($u) use ($request) {
                        $u->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        switch ($request->sort) {

            case 'created_asc':
                $query->orderBy('created_at', 'asc');
                break;

            default:
                $query->orderBy('created_at', 'desc');
        }

        $stories = $query->paginate(10)->appends($request->query());

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

    public function show(Story $story)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $story->load(['user', 'tags', 'images']);

        return view('admin.story-show', compact('story'));
    }

    public function edit(Story $story)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $story->load(['images', 'tags', 'user']);

        $tags = Tag::orderBy('name')->get();

        return view('admin.story-edit', compact('story', 'tags'));
    }

    public function update(Request $request, Story $story)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'goal_amount' => 'required|numeric'
        ]);

        $story->update([
            'title' => $request->title,
            'content' => $request->content,
            'goal_amount' => $request->goal_amount
        ]);

        if ($request->has('tags')) {
            $story->tags()->sync($request->tags);
        }

        return redirect()->route('admin.stories.show', $story);
    }
    public function detachTag(Story $story, Tag $tag)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $story->tags()->detach($tag->id);

        return back();
    }

    public function deleteImage(StoryImage $image)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $image->delete();

        return back();
    }
}
