<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;


class StoryController extends Controller
{
    public function create()
    {
        return view('story.create');
    }

    public function store(Request $request)
    {
        // 1 story per user
        if (auth()->user()->story) {
            return back()->with('error', 'Jūs jau turite sukūrę istoriją');
        }

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'goal_amount' => 'required|numeric|min:1',
            'main_image' => 'nullable|image|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('main_image')) {
            $imagePath = $request->file('main_image')->store('stories', 'public');
        }

        // ⭐ PIRMIAUSIA sukuriam story
        $story = Story::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
            'goal_amount' => $request->goal_amount,
            'main_image' => $imagePath,
        ]);


        // parse #tags from input
        if ($request->tags_text) {

            preg_match_all('/#(\w+)/u', $request->tags_text, $matches);

            foreach ($matches[1] as $tagName) {

                $tag = \App\Models\Tag::firstOrCreate([
                    'name' => strtolower($tagName)
                ]);

                $story->tags()->syncWithoutDetaching([$tag->id]);
            }
        }

        return redirect('/dashboard')->with('success', 'Istorija sukurta!');
    }
    public function index(Request $request)
    {
        $query = \App\Models\Story::where('is_approved', true)
            ->withCount('likes')
            ->with('tags');

        // jei yra tag filter
        if ($request->tag) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('name', $request->tag);
            });
        }

        $stories = $query
            ->orderBy('is_completed', 'asc')
            ->orderBy('likes_count', 'desc')
            ->get();

        $tags = \App\Models\Tag::all();

        return view('story.index', compact('stories', 'tags'));
    }
}
