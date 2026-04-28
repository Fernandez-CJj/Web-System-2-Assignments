@extends('layouts.app')

@section('content')
    <section class="section-head">
        <div>
            <p class="eyebrow">Community</p>
            <h1>Find players</h1>
        </div>
        <a class="button" href="{{ route('profile.edit') }}">Edit Profile</a>
    </section>

    <form class="filters" method="GET">
        <input name="q" value="{{ request('q') }}" placeholder="Username">
        <input name="game" value="{{ request('game') }}" placeholder="Preferred game">
        <select name="sort">
            <option value="">Sort by</option>
            <option value="rating" @selected(request('sort') === 'rating')>Rating</option>
            <option value="activity" @selected(request('sort') === 'activity')>Activity</option>
        </select>
        <button class="button" type="submit">Search</button>
    </form>

    <section class="cards">
        @foreach($players as $player)
            <article class="card">
                <h2><a href="{{ route('players.show', $player) }}">{{ $player->username }}</a></h2>
                <p class="muted">{{ $player->preferred_games ?: 'No preferred games listed.' }}</p>
                <span class="badge">Rating {{ number_format($player->received_ratings_avg_score ?: 0, 1) }}</span>
            </article>
        @endforeach
    </section>

    {{ $players->links() }}
@endsection
