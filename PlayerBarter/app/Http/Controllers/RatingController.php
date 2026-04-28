<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\TradeRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request, TradeRequest $trade): RedirectResponse
    {
        abort_unless($trade->status === 'completed', 422);
        abort_unless(in_array($request->user()->id, $trade->participantIds(), true), 403);

        $attributes = $request->validate([
            'score' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $ratedUserId = $request->user()->id === $trade->requester_id ? $trade->owner_id : $trade->requester_id;

        Rating::updateOrCreate(
            ['trade_request_id' => $trade->id, 'rater_id' => $request->user()->id],
            $attributes + ['rated_user_id' => $ratedUserId]
        );

        return back()->with('status', 'Feedback saved.');
    }
}
