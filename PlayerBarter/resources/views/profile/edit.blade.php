@extends('layouts.app')

@section('content')
    <section class="form-shell form-shell-wide">
        <div class="form-header">
            <p class="eyebrow">Player identity</p>
            <h1>Edit profile</h1>
            <p class="form-subtitle">Keep your public trading profile clear so other players know what you play and how you trade.</p>
        </div>
        <form method="POST" action="{{ route('profile.update') }}" class="stack" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-grid">
                <div class="field field-wide">
                    <label for="profile_picture">Profile picture</label>
                    <div class="profile-photo-control">
                        @include('players._avatar', ['user' => $user, 'size' => 'lg'])
                        <div>
                            <input id="profile_picture" type="file" name="profile_picture" accept="image/*">
                            <span class="field-hint">Upload a square image up to 2 MB. A new upload replaces the current picture.</span>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label for="username">Username</label>
                    <input id="username" name="username" value="{{ old('username', $user->username) }}" required>
                </div>
                <div class="field field-wide">
                    <label for="preferred_games">Preferred games</label>
                    @include('shared._preferred_games_select', ['preferredGames' => $preferredGames, 'selected' => $user->preferred_games])
                    <span class="field-hint">Select any number of games. Use each chip's x button to remove a game.</span>
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
