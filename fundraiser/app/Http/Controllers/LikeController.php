<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Story;

class LikeController extends Controller
{
    public function toggle($storyId)
    {
        $story = Story::findOrFail($storyId);

        $like = Like::where('user_id', auth()->id())
            ->where('story_id', $storyId)
            ->first();

        if ($like) {
            $like->delete(); // unlike
        } else {
            Like::create([
                'user_id' => auth()->id(),
                'story_id' => $storyId
            ]);
        }

        return back();
    }
}
