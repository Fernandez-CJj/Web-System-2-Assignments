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
</body>
</html>
