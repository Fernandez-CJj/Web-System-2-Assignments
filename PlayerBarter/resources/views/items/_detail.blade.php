@php($hasActiveRequest = (bool) ($item->has_active_request_from_current_user ?? false))

<div class="item-detail">
    <div class="item-detail-media">
        @include('items._gallery', ['item' => $item, 'limit' => 6])
    </div>

    <div class="item-detail-body">
        <div class="item-detail-title">
            <div>
                <span class="field-label">Trade item</span>
                <h2>{{ $item->name }}</h2>
            </div>
            <span class="badge">{{ $item->availability_status }}</span>
        </div>

        <div class="trade-item-meta">
            <span>{{ $item->type }}</span>
            <span>{{ $item->game_category }}</span>
            <span>{{ $item->rarity }}</span>
        </div>

        <p>{{ $item->description ?: 'No description provided.' }}</p>

        <div class="owner-line">
            <span>Owner</span>
            @include('players._identity', ['user' => $item->user, 'size' => 'sm'])
            <span class="muted">Rating {{ $item->user->ratingAverage() ?: 'N/A' }}</span>
        </div>

        <div class="item-detail-actions">
            @if($hasActiveRequest)
                <div class="modal-offer-form">
                    <span class="context-chip">Request sent</span>
                    <p class="muted">You already have an active trade request for this item. Continue the conversation from your trades page.</p>
                    <a class="button primary" href="{{ route('trades.index') }}">Open Trades</a>
                </div>
            @elseif(! auth()->user()->isAdmin() && $item->user_id !== auth()->id() && $item->availability_status === 'available')
                <form method="POST" action="{{ route('trades.store', $item) }}" class="modal-offer-form">
                    @csrf
                    <label for="modal-message-{{ $item->id }}">Offer message</label>
                    <textarea id="modal-message-{{ $item->id }}" name="message" rows="4" maxlength="1000" placeholder="Write your offer, trade details, schedule, or questions for the lister."></textarea>
                    <button class="button primary" type="submit">Send Offer</button>
                </form>
            @elseif($item->user_id === auth()->id())
                <p class="muted">This is your listing, so other players will see the offer box here.</p>
            @else
                <p class="muted">This item is not available for new offers right now.</p>
            @endif

            <a class="button" href="{{ route('reports.create', ['item' => $item->id, 'user' => $item->user_id]) }}">Report Listing</a>
        </div>
    </div>
</div>
