@extends('layouts.app')

@section('content')
    <section class="hero">
        <div>
            <p class="eyebrow">Digital gamer trading and social platform</p>
            <h1>PlayerBarter</h1>
            <p class="hero-copy">List virtual items, find trusted players, coordinate safe trades, confirm completion, and build a visible trading reputation.</p>
            <div class="actions">
                @auth
                    <a class="button primary" href="{{ route('dashboard') }}">Open Dashboard</a>
                    <a class="button" href="{{ route('items.index') }}">Browse Items</a>
                @else
                    <a class="button primary" href="{{ route('register') }}">Create Account</a>
                    <a class="button" href="{{ route('login') }}">Sign In</a>
                @endauth
            </div>
        </div>
        <div class="hero-panel">
            <div class="trade-preview">
                <span class="badge hot">Live request</span>
                <strong>Neon Phantom Skin</strong>
                <p>Valorant cosmetic | Epic rarity</p>
                <div class="progress-line"><span></span></div>
                <div class="row compact">
                    <small>Owner confirmed</small>
                    <small>Awaiting player</small>
                </div>
            </div>
            <div class="metric"><strong>4</strong><span>Trade item classes</span></div>
            <div class="metric"><strong>2-step</strong><span>completion confirmation</span></div>
            <div class="metric"><strong>Admin</strong><span>moderation and logs</span></div>
        </div>
    </section>
@endsection
