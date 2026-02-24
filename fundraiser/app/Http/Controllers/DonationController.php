<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Story;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function donate(Request $request, $storyId)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $story = Story::findOrFail($storyId);

        // jei tikslas jau pasiektas
        if ($story->is_completed) {
            return back()->with('error', 'Tikslas jau pasiektas');
        }

        Donation::create([
            'user_id' => auth()->id(),
            'story_id' => $storyId,
            'amount' => $request->amount
        ]);

        // atnaujinam surinktą sumą
        $story->current_amount = $story->donations()->sum('amount');

        if ($story->current_amount >= $story->goal_amount) {
            $story->is_completed = true;
        } else {
            $story->is_completed = false;
        }

        $story->save();

        return back();
    }
}
