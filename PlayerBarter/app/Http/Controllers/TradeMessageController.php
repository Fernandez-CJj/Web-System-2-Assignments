<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Models\TradeRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TradeMessageController extends Controller
{
    public function store(Request $request, TradeRequest $trade): RedirectResponse
    {
        abort_if($request->user()->isAdmin(), 403, 'Admins review trade activity from the admin trade logs.');
        abort_unless(in_array($request->user()->id, $trade->participantIds(), true), 403);
        abort_unless(in_array($trade->status, ['pending', 'accepted'], true), 422, 'Closed trades cannot receive new messages.');

        $attributes = $request->validate([
            'body' => ['required', 'string', 'max:1000'],
        ]);

        $trade->messages()->create([
            'user_id' => $request->user()->id,
            'body' => $attributes['body'],
        ]);

        $recipientId = $request->user()->id === $trade->requester_id
            ? $trade->owner_id
            : $trade->requester_id;

        AppNotification::create([
            'user_id' => $recipientId,
            'title' => 'Trade message received',
            'body' => $request->user()->username.' replied about '.$trade->item->name.'.',
            'link' => route('trades.index'),
        ]);

        return back()->with('status', 'Trade message sent.');
    }
}
