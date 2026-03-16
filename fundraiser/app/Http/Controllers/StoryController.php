<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;
use App\Http\Requests\StoreStoryRequest;


class StoryController extends Controller
{
    public function create()
    {
        return view('story.create');
    }

    public function store(StoreStoryRequest $request)
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

        // gallery upload
        if ($request->hasFile('gallery_images')) {

            foreach ($request->file('gallery_images') as $image) {

                $path = $image->store('stories/gallery', 'public');

                \App\Models\StoryImage::create([
                    'story_id' => $story->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect('/dashboard')->with('success', 'Istorija sukurta!');
    }
    public function index(Request $request)
    {
        $query = \App\Models\Story::where('is_approved', true)
            ->withCount('likes')
            ->with(['tags', 'donations.user', 'images']);

        // jei yra tag filter
        if ($request->tag) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('name', $request->tag);
            });
        }

        $stories = $query
            ->orderBy('is_completed', 'asc')
            ->orderBy('likes_count', 'desc')
            ->paginate(9)
            ->withQueryString();

        $tags = \App\Models\Tag::all();

        return view('story.index', compact('stories', 'tags'));
    }

    public function edit(Story $story)
    {
        // tik savo story
        if ($story->user_id !== auth()->id()) {
            abort(403);
        }

        // jei jau patvirtinta – nebeleidžiam
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

        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('stories', 'public');
            $story->main_image = $path;
        }

        $story->title = $request->title;
        $story->content = $request->content;
        $story->goal_amount = $request->goal_amount;

        $story->save();

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
}
