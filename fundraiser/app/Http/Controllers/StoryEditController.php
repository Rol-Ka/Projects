<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateStoryRequest;

class StoryEditController extends Controller
{
    public function edit(Story $story)
    {
        if ($story->user_id !== Auth::id()) {
            abort(403);
        }

        if ($story->is_approved) {
            return redirect()->route('dashboard')
                ->with('error', 'Istorija jau patvirtinta ir negali būti redaguojama');
        }

        return view('story.edit', compact('story'));
    }

    public function update(UpdateStoryRequest $request, Story $story)
    {
        if ($story->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validated();


        $story->update([
            'title' => $data['title'],
            'content' => $data['content'],
            'goal_amount' => $data['goal_amount'],
        ]);


        if ($request->tags_text) {

            preg_match_all('/#(\w+)/u', $request->tags_text, $matches);

            $tagIds = [];

            foreach ($matches[1] as $tagName) {

                $tag = \App\Models\Tag::firstOrCreate([
                    'name' => strtolower($tagName)
                ]);

                $tagIds[] = $tag->id;
            }

            $story->tags()->sync($tagIds);
        }

        if ($request->hasFile('main_image')) {


            if ($story->main_image) {
                Storage::disk('public')->delete($story->main_image);
            }

            $path = $request->file('main_image')->store('stories/main', 'public');

            $story->main_image = $path;
            $story->save();
        } elseif ($request->input('delete_main_image') && $story->main_image) {

            Storage::disk('public')->delete($story->main_image);

            $story->main_image = null;
            $story->save();
        }

        $deleteImages = $request->input('delete_images', []);

        if (!empty($deleteImages)) {

            $images = $story->images()->whereIn('id', $deleteImages)->get();

            foreach ($images as $img) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
        }


        if ($request->hasFile('gallery_images')) {

            foreach ($request->file('gallery_images') as $file) {

                if (!$file) continue;

                $path = $file->store('stories/gallery', 'public');

                $story->images()->create([
                    'image_path' => $path
                ]);
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Istorija atnaujinta',
                'redirect' => route('dashboard')
            ]);
        }

        return redirect()
            ->route('story.show', $story)
            ->with('success', 'Istorija atnaujinta');
    }
}
