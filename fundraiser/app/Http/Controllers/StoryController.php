<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;
use App\Http\Requests\StoreStoryRequest;
use Illuminate\Support\Facades\Storage;


class StoryController extends Controller
{

    public function create()
    {
        if (auth()->user()->story) {
            return view('story.already-exists');
        }

        return view('story.create');
    }

    public function store(StoreStoryRequest $request)
    {
        if (auth()->user()->story) {

            // 🔥 jei fetch (modal)
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Jūs jau turite sukūrę istoriją'
                ], 422);
            }

            return back()->with('error', 'Jūs jau turite sukūrę istoriją');
        }

        $imagePath = null;

        if ($request->hasFile('main_image')) {
            $imagePath = $request->file('main_image')->store('stories', 'public');
        }

        $story = Story::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
            'goal_amount' => $request->goal_amount,
            'main_image' => $imagePath,
        ]);

        // 🔥 TAGS
        if ($request->tags_text) {

            preg_match_all('/#(\w+)/u', $request->tags_text, $matches);

            foreach ($matches[1] as $tagName) {

                $tag = \App\Models\Tag::firstOrCreate([
                    'name' => strtolower($tagName)
                ]);

                $story->tags()->syncWithoutDetaching([$tag->id]);
            }
        }

        // 🔥 GALLERY
        if ($request->hasFile('gallery_images')) {

            foreach ($request->file('gallery_images') as $image) {

                $path = $image->store('stories/gallery', 'public');

                \App\Models\StoryImage::create([
                    'story_id' => $story->id,
                    'image_path' => $path,
                ]);
            }
        }

        // 🔥 👇 SVARBIAUSIAS ADD
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Istorija sukurta',
                'redirect' => url('/dashboard')
            ]);
        }

        return redirect('/dashboard')->with('success', 'Istorija sukurta!');
    }

    public function index(Request $request)
    {
        $query = \App\Models\Story::where('is_approved', true)
            ->withCount('likes')
            ->with(['tags', 'donations.user', 'images']);

        if ($request->tag) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('name', $request->tag);
            });
        }

        // 🔥 SORT
        if ($request->sort === 'likes_desc') {
            $query->orderBy('likes_count', 'desc');
        } elseif ($request->sort === 'likes_asc') {
            $query->orderBy('likes_count', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $activeStories = $query->clone()
            ->where('is_completed', false)
            ->orderBy('created_at', 'desc')
            ->get();

        $completedStories = $query->clone()
            ->where('is_completed', true)
            ->orderBy('completed_at', 'desc')
            ->get();

        $tags = \App\Models\Tag::all();

        return view('story.index', [
            'activeStories' => $activeStories,
            'completedStories' => $completedStories,
            'tags' => $tags
        ]);
    }

    public function edit(Story $story)
    {
        if ($story->user_id !== auth()->id()) {
            abort(403);
        }

        if ($story->is_approved) {
            return redirect('/dashboard')->with('error', 'Istorija jau patvirtinta ir nebegali būti redaguojama.');
        }

        return view('story.edit', compact('story'));
    }

    public function update(Request $request, Story $story)
    {
        if ($story->user_id !== auth()->id()) {
            abort(403);
        }

        if ($story->is_approved) {
            abort(403);
        }

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'goal_amount' => 'required|numeric|min:1',
            'main_image' => 'nullable|image|max:2048'
        ]);

        // 🔥 ištrinam main image jei pažymėta
        if ($request->delete_main_image && $story->main_image) {
            Storage::disk('public')->delete($story->main_image);
            $story->main_image = null;
        }

        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('stories', 'public');
            $story->main_image = $path;
        }

        $story->title = $request->title;
        $story->content = $request->content;
        $story->goal_amount = $request->goal_amount;

        $story->save();

        // 🔥 ADD THIS
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Istorija atnaujinta',
                'redirect' => url('/dashboard')
            ]);
        }

        return redirect('/dashboard')->with('success', 'Istorija atnaujinta!');
    }

    public function show(Story $story)
    {
        $story->load([
            'user',
            'tags',
            'images',
            'donations.user'
        ]);

        return view('story.show', compact('story'));
    }

    public function destroy(Story $story)
    {
        if ($story->user_id !== auth()->id()) {
            abort(403);
        }

        // 🔥 ištrinam main image
        if ($story->main_image) {
            Storage::disk('public')->delete($story->main_image);
        }

        // 🔥 ištrinam galeriją
        foreach ($story->images as $img) {
            Storage::disk('public')->delete($img->image_path);
            $img->delete();
        }

        // 🔥 ištrinam story
        $story->delete();

        return response()->json([
            'message' => 'Istorija ištrinta',
            'redirect' => url('/dashboard')
        ]);
    }
}
