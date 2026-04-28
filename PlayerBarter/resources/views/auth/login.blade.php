@extends('layouts.app')

@section('content')
    <section class="form-shell auth-form">
        <div class="form-header">
            <p class="eyebrow">Secure access</p>
            <h1>Sign in</h1>
            <p class="form-subtitle">Continue to your trading dashboard and manage your active requests.</p>
        </div>
        <form method="POST" action="{{ route('login') }}" class="stack">
            @csrf
            <div class="field">
                <label for="email">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="player@example.com" required>
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" autocomplete="current-password" placeholder="Enter your password" required>
            </div>
            <label class="checkbox-field"><input type="checkbox" name="remember" value="1"> <span>Keep me signed in on this device</span></label>
            <div class="form-actions">
                <button class="button primary" type="submit">Sign In</button>
                <a class="button" href="{{ route('register') }}">Create Account</a>
            </div>
        </form>
    </section>
@endsection
