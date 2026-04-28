<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Models\TradeItem;
use App\Models\TradeRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TradeRequestController extends Controller
{
    public function index(Request $request): View
    {
        abort_if(auth()->user()->isAdmin(), 403, 'Admins review trade activity from the admin trade logs.');

        $activeStatuses = ['pending', 'accepted'];
        $finishedStatuses = ['completed', 'cancelled', 'rejected'];
        $viewMode = $request->query('view') === 'finished' ? 'finished' : 'ongoing';

        $participantFilter = fn ($query) => $query
            ->where('requester_id', auth()->id())
            ->orWhere('owner_id', auth()->id());

        $finishedCount = TradeRequest::query()
            ->whereIn('status', $finishedStatuses)
            ->where($participantFilter)
            ->count();

        $activeCount = TradeRequest::query()
            ->whereIn('status', $activeStatuses)
            ->where($participantFilter)
            ->count();

        return view('trades.index', [
            'viewMode' => $viewMode,
            'activeCount' => $activeCount,
            'finishedCount' => $finishedCount,
            'incoming' => auth()->user()
                ->receivedTradeRequests()
                ->whereIn('status', $activeStatuses)
                ->with(['item', 'requester', 'messages.user'])
                ->latest('id')
                ->paginate(5, ['*'], 'incoming_page')
                ->withQueryString(),
            'outgoing' => auth()->user()
                ->sentTradeRequests()
                ->whereIn('status', $activeStatuses)
                ->with(['item', 'owner', 'messages.user'])
                ->latest('id')
                ->paginate(5, ['*'], 'outgoing_page')
                ->withQueryString(),
            'history' => $viewMode === 'finished'
                ? TradeRequest::query()
                    ->whereIn('status', $finishedStatuses)
                    ->where($participantFilter)
                    ->with(['item', 'requester', 'owner', 'ratings', 'messages.user'])
                    ->latest('id')
                    ->paginate(8, ['*'], 'history_page')
                    ->withQueryString()
                : TradeRequest::query()
                    ->whereRaw('1 = 0')
                    ->paginate(8, ['*'], 'history_page')
                    ->withQueryString(),
        ]);
    }

    public function store(Request $request, TradeItem $item): RedirectResponse
    {
        abort_if($request->user()->isAdmin(), 403, 'Admins manage trades but cannot send trade requests.');
        abort_if($item->user_id === $request->user()->id, 403, 'You cannot request your own item.');
        abort_unless($item->availability_status === 'available', 422, 'This item is not available.');

        $attributes = $request->validate(['message' => ['nullable', 'string', 'max:1000']]);
        $trade = TradeRequest::create([
            'item_id' => $item->id,
            'requester_id' => $request->user()->id,
            'owner_id' => $item->user_id,
            'message' => $attributes['message'] ?? null,
        ]);

        if (! empty($attributes['message'])) {
            $trade->messages()->create([
                'user_id' => $request->user()->id,
                'body' => $attributes['message'],
            ]);
        }

        $this->notify($item->user_id, 'New trade request', $request->user()->username.' requested '.$item->name.'.', route('trades.index'));

        return redirect()->route('trades.index')->with('status', 'Trade request sent.');
    }

    public function update(Request $request, TradeRequest $trade): RedirectResponse
    {
        $attributes = $request->validate(['status' => ['required', 'in:accepted,rejected,cancelled']]);
        $isOwner = $trade->owner_id === $request->user()->id;
        $isRequesterCancelling = $trade->requester_id === $request->user()->id && $attributes['status'] === 'cancelled';

        abort_unless($isOwner || $isRequesterCancelling, 403);

        $trade->update($attributes);
        if ($attributes['status'] === 'accepted') {
            $trade->item->update(['availability_status' => 'reserved']);
        }
        if (in_array($attributes['status'], ['rejected', 'cancelled'], true) && $trade->item->availability_status !== 'traded') {
            $trade->item->update(['availability_status' => 'available']);
        }

        $recipientId = $isOwner ? $trade->requester_id : $trade->owner_id;
        $body = $attributes['status'] === 'accepted'
            ? 'Your request for '.$trade->item->name.' was accepted. Confirm completion after the trade is coordinated.'
            : 'The trade request for '.$trade->item->name.' was '.$attributes['status'].'.';
        $this->notify($recipientId, 'Trade request '.$attributes['status'], $body, route('trades.index'));

        return back()->with('status', 'Trade status updated.');
    }

    public function confirm(Request $request, TradeRequest $trade): RedirectResponse
    {
        abort_unless(in_array($request->user()->id, $trade->participantIds(), true), 403);
        abort_unless($trade->status === 'accepted', 422, 'Only accepted trades can be confirmed.');

        $field = $request->user()->id === $trade->requester_id ? 'requester_confirmed' : 'owner_confirmed';
        $trade->update([$field => true]);
        $trade->refresh();

        if ($trade->requester_confirmed && $trade->owner_confirmed) {
            $trade->update(['status' => 'completed', 'completed_at' => now()]);
            $trade->item->update(['user_id' => $trade->requester_id, 'availability_status' => 'traded']);
            $this->notify($trade->requester_id, 'Trade completed', 'Both players confirmed '.$trade->item->name.'.', route('trades.index'));
            $this->notify($trade->owner_id, 'Trade completed', 'Both players confirmed '.$trade->item->name.'.', route('trades.index'));
        }

        return back()->with('status', 'Trade confirmation recorded.');
    }

    private function notify(int $userId, string $title, string $body, string $link): void
    {
        AppNotification::create([
            'user_id' => $userId,
            'title' => $title,
            'body' => $body,
            'link' => $link,
        ]);
    }
}
