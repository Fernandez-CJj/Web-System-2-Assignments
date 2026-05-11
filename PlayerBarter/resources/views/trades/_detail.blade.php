@php
    $isOwner = $trade->owner_id === auth()->id();
    $isRequester = $trade->requester_id === auth()->id();
@endphp

<div class="trade-detail">
    <div class="trade-detail-head">
        <div>
            <span class="field-label">Trade coordination</span>
            <h2>{{ $trade->item->name }}</h2>
            <div class="trade-detail-participants">
                <span>Requester @include('players._identity', ['user' => $trade->requester, 'size' => 'sm'])</span>
                <span>Owner @include('players._identity', ['user' => $trade->owner, 'size' => 'sm'])</span>
            </div>
        </div>
        <span class="badge">{{ $trade->status }}</span>
    </div>

    @include('trades._item_summary', ['item' => $trade->item])
    @include('trades._thread', ['trade' => $trade])

    <div class="trade-detail-actions">
        @if($trade->status === 'pending' && $isOwner)
            <form method="POST" action="{{ route('trades.update', $trade) }}" class="actions">
                @csrf @method('PATCH')
                <button class="button primary" name="status" value="accepted">Accept</button>
                <button class="button danger" name="status" value="rejected">Reject</button>
            </form>
        @elseif($trade->status === 'accepted' && $isOwner)
            <form method="POST" action="{{ route('trades.confirm', $trade) }}">
                @csrf @method('PATCH')
                <button class="button primary" type="submit">{{ $trade->owner_confirmed ? 'Confirmed' : 'Confirm Completion' }}</button>
            </form>
            <form method="POST" action="{{ route('trades.update', $trade) }}">
                @csrf @method('PATCH')
                <button class="button danger" name="status" value="cancelled">Cancel Trade</button>
            </form>
        @endif

        @if($trade->status === 'accepted' && $isRequester)
            <form method="POST" action="{{ route('trades.confirm', $trade) }}">
                @csrf @method('PATCH')
                <button class="button primary" type="submit">{{ $trade->requester_confirmed ? 'Confirmed' : 'Confirm Completion' }}</button>
            </form>
        @endif

        @if($isRequester && in_array($trade->status, ['pending', 'accepted'], true))
            <form method="POST" action="{{ route('trades.update', $trade) }}">
                @csrf @method('PATCH')
                <button class="button danger" name="status" value="cancelled">Cancel Request</button>
            </form>
        @endif
    </div>
</div>
