@extends('layouts.app')

@section('content')
    <section class="form-shell form-shell-wide">
        <div class="form-header">
            <p class="eyebrow">Join PlayerBarter</p>
            <h1>Create player account</h1>
            <p class="form-subtitle">Set up your trading identity, preferred games, and coordination preferences.</p>
        </div>
        <form method="POST" action="{{ route('register') }}" class="stack">
            @csrf
            <div class="form-grid">
                <div class="field">
                    <label for="username">Username</label>
                    <input id="username" name="username" value="{{ old('username') }}" autocomplete="username" placeholder="pixeltrader" required>
                    <span class="field-hint">Use letters, numbers, dashes, or underscores.</span>
                </div>
                <div class="field field-wide">
                    <label for="email">Email address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="player@example.com" required>
                </div>
                <div class="field field-wide">
                    <label for="preferred_games">Preferred games</label>
                    <input id="preferred_games" name="preferred_games" value="{{ old('preferred_games') }}" placeholder="Valorant, Dota 2, Fortnite">
                </div>
                <div class="field field-wide">
                    <label for="trading_preferences">Trading preferences</label>
                    <textarea id="trading_preferences" name="trading_preferences" rows="4" placeholder="Preferred item types, trade windows, or safety notes">{{ old('trading_preferences') }}</textarea>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" autocomplete="new-password" placeholder="Create a secure password" minlength="8" pattern="(?=.*[A-Za-z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}" required>
                    <span class="field-hint">Use at least 8 characters with a letter, number, and special character.</span>
                </div>
                <div class="field">
                    <label for="password_confirmation">Confirm password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" placeholder="Repeat your password" required>
                </div>
            </div>
            <div class="form-actions">
                <button class="button primary" type="submit">Create Account</button>
                <a class="button" href="{{ route('login') }}">Already Registered</a>
            </div>
        </form>
    </section>
@endsection
