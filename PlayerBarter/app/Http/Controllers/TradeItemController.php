<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TradeItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TradeItemController extends Controller
{
    public function index(Request $request): View
    {
        $publicStatuses = ['available', 'reserved'];
        $requestedStatus = in_array($request->status, $publicStatuses, true) ? $request->status : null;

        $items = TradeItem::query()
            ->with(['user.receivedRatings', 'images'])
            ->withExists([
                'tradeRequests as has_active_request_from_current_user' => fn ($query) => $query
                    ->where('requester_id', auth()->id())
                    ->whereIn('status', ['pending', 'accepted']),
            ])
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

        return view('items.create', [
            'item' => new TradeItem(),
            'preferredGames' => User::PREFERRED_GAMES,
            'types' => TradeItem::TYPES,
            'rarities' => TradeItem::RARITIES,
            'statuses' => TradeItem::STATUSES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_if($request->user()->isAdmin(), 403, 'Admins manage listings but cannot post trade items.');

        $attributes = $this->validateItem($request);
        $attributes['game_category'] = implode(', ', $attributes['game_category']);
        unset($attributes['item_images'], $attributes['remove_images']);

        $item = $request->user()->items()->create($attributes);
        $this->storeImages($request, $item);

        return redirect()->route('items.index')->with('status', 'Item listed for trade.');
    }

    public function edit(TradeItem $item): View
    {
        abort_unless($item->user_id === auth()->id(), 403);

        return view('items.edit', [
            'item' => $item->load('images'),
            'preferredGames' => User::PREFERRED_GAMES,
            'types' => TradeItem::TYPES,
            'rarities' => TradeItem::RARITIES,
            'statuses' => TradeItem::STATUSES,
        ]);
    }

    public function update(Request $request, TradeItem $item): RedirectResponse
    {
        abort_unless($item->user_id === auth()->id(), 403);

        $attributes = $this->validateItem($request);
        $removeImageIds = collect($attributes['remove_images'] ?? [])->filter();
        $this->ensureImageLimit($request, $item, $removeImageIds->all());

        $attributes['game_category'] = implode(', ', $attributes['game_category']);
        unset($attributes['item_images'], $attributes['remove_images']);
        $item->update($attributes);

        if ($removeImageIds->isNotEmpty()) {
            foreach ($item->images()->whereIn('id', $removeImageIds->all())->get() as $image) {
                $image->delete();
            }
        }

        $this->storeImages($request, $item);

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
        if ($request->filled('game_category') && ! is_array($request->input('game_category'))) {
            $request->merge(['game_category' => [$request->input('game_category')]]);
        }

        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'type' => ['required', 'in:'.implode(',', TradeItem::TYPES)],
            'game_category' => ['required', 'array', 'min:1', 'max:6'],
            'game_category.*' => ['string', Rule::in(User::PREFERRED_GAMES)],
            'rarity' => ['required', 'in:'.implode(',', TradeItem::RARITIES)],
            'availability_status' => ['required', 'in:'.implode(',', TradeItem::STATUSES)],
            'description' => ['nullable', 'string', 'max:1000'],
            'item_images' => ['nullable', 'array', 'max:6'],
            'item_images.*' => ['image', 'max:4096'],
            'remove_images' => ['nullable', 'array'],
            'remove_images.*' => ['integer'],
        ]);
    }

    private function storeImages(Request $request, TradeItem $item): void
    {
        $files = $request->file('item_images', []);

        if (! is_array($files)) {
            $files = [$files];
        }

        $nextSortOrder = (int) $item->images()->max('sort_order');

        foreach (array_filter($files) as $file) {
            $item->images()->create([
                'path' => $file->store('trade-items', 'public'),
                'original_name' => $file->getClientOriginalName(),
                'sort_order' => ++$nextSortOrder,
            ]);
        }
    }

    private function ensureImageLimit(Request $request, TradeItem $item, array $removeImageIds = []): void
    {
        $files = $request->file('item_images', []);

        if (! is_array($files)) {
            $files = [$files];
        }

        $remainingImages = $item->images()
            ->when($removeImageIds !== [], fn ($query) => $query->whereNotIn('id', $removeImageIds))
            ->count();

        if ($remainingImages + count(array_filter($files)) > 6) {
            throw ValidationException::withMessages([
                'item_images' => 'Each listing can have up to 6 images.',
            ]);
        }
    }
}
