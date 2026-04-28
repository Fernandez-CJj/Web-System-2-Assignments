<?php

namespace App\Http\Controllers;

use App\Models\TradeItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TradeItemController extends Controller
{
    public function index(Request $request): View
    {
        $publicStatuses = ['available', 'reserved'];
        $requestedStatus = in_array($request->status, $publicStatuses, true) ? $request->status : null;

        $items = TradeItem::query()
            ->with('user.receivedRatings')
            ->whereIn('availability_status', $publicStatuses)
            ->when($request->filled('q'), fn ($query) => $query->where('name', 'like', '%'.$request->q.'%'))
            ->when($request->filled('type'), fn ($query) => $query->where('type', $request->type))
            ->when($request->filled('rarity'), fn ($query) => $query->where('rarity', $request->rarity))
            ->when($requestedStatus, fn ($query) => $query->where('availability_status', $requestedStatus))
            ->when($request->filled('game'), fn ($query) => $query->where('game_category', 'like', '%'.$request->game.'%'))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('items.index', [
            'items' => $items,
            'types' => TradeItem::TYPES,
            'rarities' => TradeItem::RARITIES,
            'statuses' => $publicStatuses,
        ]);
    }

    public function create(): View
    {
        abort_if(auth()->user()->isAdmin(), 403, 'Admins manage listings but cannot post trade items.');

        return view('items.create', ['item' => new TradeItem(), 'types' => TradeItem::TYPES, 'rarities' => TradeItem::RARITIES, 'statuses' => TradeItem::STATUSES]);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_if($request->user()->isAdmin(), 403, 'Admins manage listings but cannot post trade items.');

        $request->user()->items()->create($this->validateItem($request));

        return redirect()->route('items.index')->with('status', 'Item listed for trade.');
    }

    public function edit(TradeItem $item): View
    {
        abort_unless($item->user_id === auth()->id(), 403);

        return view('items.edit', ['item' => $item, 'types' => TradeItem::TYPES, 'rarities' => TradeItem::RARITIES, 'statuses' => TradeItem::STATUSES]);
    }

    public function update(Request $request, TradeItem $item): RedirectResponse
    {
        abort_unless($item->user_id === auth()->id(), 403);
        $item->update($this->validateItem($request));

        return redirect()->route('items.index')->with('status', 'Item updated.');
    }

    public function destroy(TradeItem $item): RedirectResponse
    {
        abort_unless($item->user_id === auth()->id() || auth()->user()->isAdmin(), 403);
        $item->delete();

        return back()->with('status', 'Item deleted.');
    }

    private function validateItem(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'type' => ['required', 'in:'.implode(',', TradeItem::TYPES)],
            'game_category' => ['required', 'string', 'max:120'],
            'rarity' => ['required', 'in:'.implode(',', TradeItem::RARITIES)],
            'availability_status' => ['required', 'in:'.implode(',', TradeItem::STATUSES)],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);
    }
}
