@extends('layouts.app')

@section('content')
<div class="trades-page">
    <section class="section-head">
        <div>
            <p class="eyebrow">Coordination</p>
            <h1>{{ $viewMode === 'finished' ? 'Finished trades' : 'Ongoing trades' }}</h1>
            <p class="muted">
                {{ $viewMode === 'finished' ? 'Review completed, cancelled, and rejected trade records.' : 'Handle pending requests and accepted trades before reviewing history.' }}
            </p>
        </div>
        <div class="actions">
            @if($viewMode === 'finished')
                <a class="button primary" href="{{ route('trades.index') }}">Back to Ongoing Trades ({{ $activeCount }})</a>
            @else
                <a class="button" href="{{ route('trades.index', ['view' => 'finished']) }}">View Finished Trades ({{ $finishedCount }})</a>
            @endif
        </div>
    </section>

    @if($viewMode === 'ongoing')
    <section class="trade-board">
        <div class="panel trade-panel">
            <div class="panel-title-row">
                <h2>Incoming</h2>
                <span class="badge">{{ $incoming->total() }}</span>
            </div>
            @forelse($incoming as $trade)
                <div class="trade">
                    <div class="row"><strong>{{ $trade->item->name }}</strong><span class="badge">{{ $trade->status }}</span></div>
                    <p>From {{ $trade->requester->username }}</p>
                    @include('trades._thread', ['trade' => $trade])
                    @if($trade->status === 'pending')
                        <form method="POST" action="{{ route('trades.update', $trade) }}" class="actions">
                            @csrf @method('PATCH')
                            <button class="button primary" name="status" value="accepted">Accept</button>
                            <button class="button danger" name="status" value="rejected">Reject</button>
                        </form>
                    @elseif($trade->status === 'accepted')
                        <form method="POST" action="{{ route('trades.confirm', $trade) }}">
                            @csrf @method('PATCH')
                            <button class="button primary" type="submit">{{ $trade->owner_confirmed ? 'Confirmed' : 'Confirm Completion' }}</button>
                        </form>
                        <form method="POST" action="{{ route('trades.update', $trade) }}">
                            @csrf @method('PATCH')
                            <button class="button danger" name="status" value="cancelled">Cancel Trade</button>
                        </form>
                    @endif
                </div>
            @empty
                <p class="muted">No incoming trades.</p>
            @endforelse
            {{ $incoming->links() }}
        </div>

        <div class="panel trade-panel">
            <div class="panel-title-row">
                <h2>Outgoing</h2>
                <span class="badge">{{ $outgoing->total() }}</span>
            </div>
            @forelse($outgoing as $trade)
                <div class="trade">
                    <div class="row"><strong>{{ $trade->item->name }}</strong><span class="badge">{{ $trade->status }}</span></div>
                    <p>Owner {{ $trade->owner->username }}</p>
                    @include('trades._thread', ['trade' => $trade])
                    @if($trade->status === 'accepted')
                        <form method="POST" action="{{ route('trades.confirm', $trade) }}">
                            @csrf @method('PATCH')
                            <button class="button primary" type="submit">{{ $trade->requester_confirmed ? 'Confirmed' : 'Confirm Completion' }}</button>
                        </form>
                    @endif
                    @if(in_array($trade->status, ['pending', 'accepted'], true))
                        <form method="POST" action="{{ route('trades.update', $trade) }}">
                            @csrf @method('PATCH')
                            <button class="button danger" name="status" value="cancelled">Cancel Request</button>
                        </form>
                    @endif
                </div>
            @empty
                <p class="muted">No outgoing trades.</p>
            @endforelse
            {{ $outgoing->links() }}
        </div>
    </section>
    @else

    <section class="panel trade-panel trade-history-panel">
        <div class="panel-title-row">
            <h2>Completed and cancelled records</h2>
            <span class="badge">{{ $history->total() }}</span>
        </div>
        @forelse($history as $trade)
            <div class="trade">
                <div class="row">
                    <span>{{ $trade->item->name }} | {{ $trade->requester->username }} / {{ $trade->owner->username }}</span>
                    <span class="badge">{{ $trade->status }} {{ $trade->completed_at?->format('M d, Y') }}</span>
                </div>
                @include('trades._thread', ['trade' => $trade])
                @if($trade->status === 'completed')
                    <form method="POST" action="{{ route('ratings.store', $trade) }}" class="filters">
                        @csrf
                        <select name="score" required>
                            <option value="">Rate player</option>
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <input name="comment" placeholder="Feedback comment">
                        <button class="button" type="submit">Save Feedback</button>
                    </form>
                @endif
            </div>
        @empty
            <p class="muted">No completed, cancelled, or rejected trades yet.</p>
        @endforelse
        {{ $history->links() }}
    </section>
    @endif
</div>
@endsection
