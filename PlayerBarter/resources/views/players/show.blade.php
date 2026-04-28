@extends('layouts.app')

@section('content')
    <section class="section-head">
        <div>
            <p class="eyebrow">Player profile</p>
            <h1>{{ $player->username }}</h1>
            <p>{{ $player->preferred_games ?: 'No preferred games listed.' }}</p>
            <p class="muted">{{ $player->trading_preferences ?: 'No trading preferences listed.' }}</p>
        </div>
        <a class="button" href="{{ route('reports.create', ['user' => $player->id]) }}">Report Player</a>
    </section>

    <section class="grid two">
        <div class="panel">
            <h2>Listed items</h2>
            @forelse($player->items as $item)
                <div class="row"><span>{{ $item->name }} | {{ $item->game_category }}</span><span class="badge">{{ $item->availability_status }}</span></div>
            @empty
                <p class="muted">No active listed items.</p>
            @endforelse
        </div>
        <div class="panel">
            <h2>Feedback</h2>
            <p>Average rating: {{ $player->ratingAverage() ?: 'N/A' }}</p>
            @forelse($player->receivedRatings as $rating)
                <div class="feedback"><strong>{{ $rating->score }}/5</strong> from {{ $rating->rater->username }}<p>{{ $rating->comment }}</p></div>
            @empty
                <p class="muted">No feedback yet.</p>
            @endforelse
        </div>
    </section>
@endsection
