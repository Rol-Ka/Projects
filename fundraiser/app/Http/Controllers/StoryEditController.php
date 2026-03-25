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

        $story->update([
            'title' => $data['title'],
            'content' => $data['content'],
            'goal_amount' => $data['goal_amount'],
        ]);
        // ✅ MAIN IMAGE UPLOAD
        if ($request->hasFile('main_image')) {

            if ($story->main_image) {
                Storage::disk('public')->delete($story->main_image);
            }

            $path = $request->file('main_image')->store('stories/main', 'public');

            $story->main_image = $path;
            $story->save();
        }

        // ✅ DELETE MAIN
        if ($request->input('delete_main_image') && $story->main_image) {
            Storage::disk('public')->delete($story->main_image);
            $story->main_image = null;
            $story->save();
        }

        // ✅ DELETE GALLERY
        $deleteImages = $request->input('delete_images', []);

        if (!empty($deleteImages)) {

            $images = $story->images()->whereIn('id', $deleteImages)->get();

            foreach ($images as $img) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
        }

        // ✅ ADD GALLERY
        if ($request->hasFile('gallery_images')) {

            foreach ($request->file('gallery_images') as $file) {

                if (!$file) continue;

                $path = $file->store('stories/gallery', 'public');

                $story->images()->create([
                    'image_path' => $path
                ]);
            }
        }




        // 🔥 modal support
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
