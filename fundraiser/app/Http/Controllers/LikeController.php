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
                'message' => 'Norint uždėti širdutę, turite būti prisijungęs'
            ], 401);
        }

        $story = Story::findOrFail($id);

        if (!$story->is_approved) {
            return response()->json([
                'message' => 'Ši istorija dar nepatvirtinta'
            ], 403);
        }

        if ($story->is_completed) {
            return response()->json([
                'message' => 'Ši istorija jau užbaigta'
            ], 403);
        }

        $like = $story->likes()->where('user_id', auth()->id())->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            $story->likes()->create([
                'user_id' => auth()->id()
            ]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likes' => $story->likes()->count()
        ]);
    }
}
