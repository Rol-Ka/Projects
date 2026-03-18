<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Story;
use Illuminate\Http\Request;
use App\Http\Requests\DonateRequest;

class DonationController extends Controller
{


    public function donate(DonateRequest $request, $storyId)
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Norint aukoti, turite būti prisijungęs'
            ], 401);
        }

        $story = Story::findOrFail($storyId);

        // 🔥 jei tikslas pasiektas
        if ($story->is_completed) {
            return response()->json([
                'message' => 'Tikslas jau pasiektas'
            ], 422);
        }

        $amount = $request->amount;

        // 🔥 MAX LIMIT
        $remaining = $story->goal_amount - $story->current_amount;

        if ($amount > $remaining) {
            return response()->json([
                'message' => 'Suma viršija likusį tikslą (€' . $remaining . ')'
            ], 422);
        }

        Donation::create([
            'user_id' => auth()->id(),
            'story_id' => $storyId,
            'amount' => $amount
        ]);

        // 🔥 atnaujinam sumą
        $story->current_amount += $amount;

        if ($story->current_amount >= $story->goal_amount) {
            $story->is_completed = true;

            if (!$story->completed_at) {
                $story->completed_at = now();
            }
        }

        $story->save();

        return response()->json([
            'message' => 'Auka sėkminga 🎉',
            'current_amount' => $story->current_amount,
            'goal_amount' => $story->goal_amount,
            'is_completed' => $story->is_completed
        ]);
    }
}
