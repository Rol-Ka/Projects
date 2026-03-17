<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Story;


class LikeController extends Controller
{
    public function toggle($id)
    {
        if (!auth()->check()) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        $story = Story::findOrFail($id);
        $user = auth()->user();

        $existing = Like::where('user_id', $user->id)
            ->where('story_id', $story->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            Like::create([
                'user_id' => $user->id,
                'story_id' => $story->id
            ]);
            $liked = true;
        }

        return response()->json([
            'likes' => Like::where('story_id', $story->id)->count(),
            'liked' => $liked
        ]);
    }
}
