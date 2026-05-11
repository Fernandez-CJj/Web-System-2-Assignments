@extends('layouts.app')

@section('content')
    <section class="section-head">
        <div class="profile-summary">
            @include('players._avatar', ['user' => $player, 'size' => 'xl'])
            <div>
                <p class="eyebrow">Player profile</p>
                <h1>{{ $player->username }}</h1>
                <p>{{ $player->preferred_games ?: 'No preferred games listed.' }}</p>
                <p class="muted">{{ $player->trading_preferences ?: 'No trading preferences listed.' }}</p>
            </div>
        </div>
        <a class="button" href="{{ route('reports.create', ['user' => $player->id]) }}">Report Player</a>
    </section>

    <section class="grid two">
        <div class="panel">
            <h2>Listed items</h2>
            @forelse($player->items as $item)
                <div class="listed-item">
                    @include('items._gallery', ['item' => $item, 'limit' => 3])
                    <div class="row">
                        <span>{{ $item->name }} | {{ $item->game_category }}</span>
                        <span class="badge">{{ $item->availability_status }}</span>
                    </div>
                    <p class="muted">{{ $item->description ?: 'No description provided.' }}</p>
                </div>
            @empty
                <p class="muted">No active listed items.</p>
            @endforelse
        </div>
        <div class="panel">
            <h2>Feedback</h2>
            <p>Average rating: {{ $player->ratingAverage() ?: 'N/A' }}</p>
            @forelse($player->receivedRatings as $rating)
                <div class="feedback">
                    <strong>{{ $rating->score }}/5</strong>
                    <span>from @include('players._identity', ['user' => $rating->rater, 'size' => 'sm'])</span>
                    <p>{{ $rating->comment }}</p>
                </div>
            @empty
                <p class="muted">No feedback yet.</p>
            @endforelse
        </div>
    </section>
@endsection
