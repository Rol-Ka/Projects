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
        // 🔒 tik savininkas gali edit
        if ($story->user_id !== Auth::id()) {
            abort(403);
        }

        // 🔒 negalima edit jei patvirtinta
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

        // BASIC
        $story->update([
            'title' => $data['title'],
            'content' => $data['content'],
            'goal_amount' => $data['goal_amount'],
        ]);

        // MAIN IMAGE
        if ($request->hasFile('main_image')) {

            if ($story->main_image) {
                Storage::disk('public')->delete($story->main_image);
            }

            $path = $request->file('main_image')->store('stories', 'public');

            $story->update([
                'main_image' => $path
            ]);
        }

        // 🔥 delete main image
        if ($request->delete_main_image && $story->main_image) {
            Storage::disk('public')->delete($story->main_image);
            $story->main_image = null;
        }
        if ($request->hasFile('main_image')) {

            // 🔥 ištrinam seną
            if ($story->main_image) {
                Storage::disk('public')->delete($story->main_image);
            }

            $path = $request->file('main_image')->store('stories', 'public');
            $story->main_image = $path;
        }

        // DELETE GALLERY
        if ($request->delete_images) {

            $images = $story->images()->whereIn('id', $request->delete_images)->get();

            foreach ($images as $img) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
        }

        // ADD GALLERY
        if ($request->hasFile('gallery_images')) {

            foreach ($request->file('gallery_images') as $file) {

                $path = $file->store('stories', 'public');

                $story->images()->create([
                    'image_path' => $path
                ]);
            }
        }

        return redirect()
            ->route('story.show', $story)
            ->with('success', 'Istorija atnaujinta');
    }
}
