@extends('layouts.app')

@section('content')
    <section class="form-shell form-shell-wide">
        <div class="form-header">
            <p class="eyebrow">Player identity</p>
            <h1>Edit profile</h1>
            <p class="form-subtitle">Keep your public trading profile clear so other players know what you play and how you trade.</p>
        </div>
        <form method="POST" action="{{ route('profile.update') }}" class="stack">
            @csrf @method('PUT')
            <div class="form-grid">
                <div class="field">
                    <label for="username">Username</label>
                    <input id="username" name="username" value="{{ old('username', $user->username) }}" required>
                </div>
                <div class="field field-wide">
                    <label for="preferred_games">Preferred games</label>
                    <input id="preferred_games" name="preferred_games" value="{{ old('preferred_games', $user->preferred_games) }}" placeholder="Valorant, Dota 2, Fortnite">
                </div>
                <div class="field field-wide">
                    <label for="trading_preferences">Trading preferences</label>
                    <textarea id="trading_preferences" name="trading_preferences" rows="5" placeholder="Preferred trade style, availability, or item interests">{{ old('trading_preferences', $user->trading_preferences) }}</textarea>
                </div>
            </div>
            <div class="form-actions">
                <button class="button primary" type="submit">Save Profile</button>
                <a class="button" href="{{ route('dashboard') }}">Cancel</a>
            </div>
        </form>
    </section>
@endsection
