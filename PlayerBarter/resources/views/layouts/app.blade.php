<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'PlayerBarter') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="topbar">
        <a class="brand" href="{{ route('home') }}">
            <span class="brand-mark">PB</span>
            <span>PlayerBarter</span>
        </a>
        <nav>
            @auth
                @php($unreadNotifications = auth()->user()->notifications()->whereNull('read_at')->count())
                <a @class(['active' => request()->routeIs('dashboard')]) href="{{ route('dashboard') }}">Dashboard</a>
                @unless(auth()->user()->isAdmin())
                    <a @class(['active' => request()->routeIs('items.*')]) href="{{ route('items.index') }}">Items</a>
                    <a @class(['active' => request()->routeIs('players.*')]) href="{{ route('players.index') }}">Players</a>
                    <a @class(['active' => request()->routeIs('trades.*')]) href="{{ route('trades.index') }}">Trades</a>
                @endunless
                <a @class(['active' => request()->routeIs('notifications.*'), 'nav-alert-link' => true]) href="{{ route('notifications.index') }}">
                    Alerts
                    @if($unreadNotifications > 0)
                        <span class="nav-badge">{{ $unreadNotifications }}</span>
                    @endif
                </a>
                <a @class(['active' => request()->routeIs('profile.*')]) href="{{ route('profile.edit') }}">Profile</a>
                @if(auth()->user()->isAdmin())
                    <a @class(['active' => request()->routeIs('admin.*')]) href="{{ route('admin.index') }}">Admin</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <a @class(['active' => request()->routeIs('login')]) href="{{ route('login') }}">Login</a>
                <a class="nav-cta" href="{{ route('register') }}">Register</a>
            @endauth
        </nav>
    </header>

    <main class="page">
        @if(session('status'))
            <div class="notice">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="notice danger">{{ $errors->first() }}</div>
        @endif
        @yield('content')
    </main>

    <div class="photo-modal" data-image-modal role="dialog" aria-modal="true" aria-label="Image preview" hidden>
        <button class="photo-modal-backdrop" type="button" data-image-modal-close aria-label="Close image preview"></button>
        <div class="photo-modal-dialog">
            <button class="photo-modal-close" type="button" data-image-modal-close aria-label="Close image preview">x</button>
            <img data-image-modal-image alt="">
            <p data-image-modal-caption></p>
        </div>
    </div>

    <div class="item-modal" data-item-modal role="dialog" aria-modal="true" aria-label="Item details" hidden>
        <button class="item-modal-backdrop" type="button" data-item-modal-close aria-label="Close item details"></button>
        <div class="item-modal-dialog">
            <button class="item-modal-close" type="button" data-item-modal-close aria-label="Close item details">x</button>
            <div data-item-modal-content></div>
        </div>
    </div>

    <div class="trade-modal" data-trade-modal role="dialog" aria-modal="true" aria-label="Trade details" hidden>
        <button class="trade-modal-backdrop" type="button" data-trade-modal-close aria-label="Close trade details"></button>
        <div class="trade-modal-dialog">
            <button class="trade-modal-close" type="button" data-trade-modal-close aria-label="Close trade details">x</button>
            <div data-trade-modal-content></div>
        </div>
    </div>
</body>
</html>
