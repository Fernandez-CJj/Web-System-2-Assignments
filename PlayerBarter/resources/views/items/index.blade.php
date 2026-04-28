@extends('layouts.app')

@section('content')
    <section class="section-head">
        <div>
            <p class="eyebrow">Marketplace</p>
            <h1>Available trade items</h1>
        </div>
        @unless(auth()->user()->isAdmin())
            <a class="button primary" href="{{ route('items.create') }}">Add Item</a>
        @endunless
    </section>

    <form class="filters" method="GET">
        <input name="q" value="{{ request('q') }}" placeholder="Search item">
        <input name="game" value="{{ request('game') }}" placeholder="Game category">
        <select name="type"><option value="">All types</option>@foreach($types as $type)<option @selected(request('type') === $type)>{{ $type }}</option>@endforeach</select>
        <select name="rarity"><option value="">All rarities</option>@foreach($rarities as $rarity)<option @selected(request('rarity') === $rarity)>{{ $rarity }}</option>@endforeach</select>
        <select name="status"><option value="">All statuses</option>@foreach($statuses as $status)<option @selected(request('status') === $status)>{{ $status }}</option>@endforeach</select>
        <button class="button" type="submit">Filter</button>
    </form>

    <section class="cards">
        @forelse($items as $item)
            <article class="card">
                <div class="row">
                    <h2>{{ $item->name }}</h2>
                    <span class="badge">{{ $item->availability_status }}</span>
                </div>
                <p>{{ $item->type }} | {{ $item->game_category }} | {{ $item->rarity }}</p>
                <p class="muted">{{ $item->description ?: 'No description provided.' }}</p>
                <p>Owner: <a href="{{ route('players.show', $item->user) }}">{{ $item->user->username }}</a> | Rating {{ $item->user->ratingAverage() ?: 'N/A' }}</p>
                <div class="actions">
                    @if(! auth()->user()->isAdmin() && $item->user_id !== auth()->id() && $item->availability_status === 'available')
                        <form method="POST" action="{{ route('trades.store', $item) }}" class="trade-request-form">
                            @csrf
                            <label class="sr-only" for="message-{{ $item->id }}">Offer note</label>
                            <input id="message-{{ $item->id }}" name="message" placeholder="Optional offer note">
                            <button class="button primary" type="submit">Request Trade</button>
                        </form>
                    @endif
                    @if($item->user_id === auth()->id())
                        <a class="button" href="{{ route('items.edit', $item) }}">Edit</a>
                        <form method="POST" action="{{ route('items.destroy', $item) }}">
                            @csrf @method('DELETE')
                            <button class="button danger" type="submit">Delete</button>
                        </form>
                    @elseif(auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('items.destroy', $item) }}">
                            @csrf @method('DELETE')
                            <button class="button danger" type="submit">Delete</button>
                        </form>
                    @endif
                    <a class="button" href="{{ route('reports.create', ['item' => $item->id, 'user' => $item->user_id]) }}">Report</a>
                </div>
            </article>
        @empty
            <p class="muted">No active trade items match the current filters.</p>
        @endforelse
    </section>

    {{ $items->links() }}
@endsection
