@extends('layouts.app')

@section('content')
    <section class="section-head">
        <div>
            <p class="eyebrow">Welcome, {{ auth()->user()->username }}</p>
            <h1>Trading dashboard</h1>
        </div>
        <div class="actions">
            <a class="button" href="{{ route('profile.edit') }}">Edit Profile</a>
            @if(auth()->user()->isAdmin())
                <a class="button primary" href="{{ route('admin.index') }}">Open Admin Panel</a>
            @else
                <a class="button primary" href="{{ route('items.create') }}">List Item</a>
            @endif
        </div>
    </section>

    <section class="stats">
        @foreach($totals as $label => $value)
            <div class="stat"><strong>{{ $value }}</strong><span>{{ str_replace('_', ' ', $label) }}</span></div>
        @endforeach
    </section>

    @if(auth()->user()->isAdmin())
        <section class="grid two">
            <div class="panel">
                <h2>Moderation shortcuts</h2>
                <div class="actions">
                    <a class="button primary" href="{{ route('admin.index') }}">Manage Platform</a>
                    <a class="button" href="{{ route('admin.reports') }}">Review Reports</a>
                    <a class="button" href="{{ route('admin.logs') }}">Trade Logs</a>
                </div>
            </div>
            <div class="panel">
                <div class="panel-title-row">
                    <h2>Admin alerts</h2>
                    <a href="{{ route('notifications.index') }}">View all</a>
                </div>
                @forelse($notifications as $notification)
                    <form method="POST" action="{{ route('notifications.update', $notification) }}" class="row">
                        @csrf @method('PATCH')
                        <span>{{ $notification->title }}</span>
                        <button class="link-button">{{ $notification->read_at ? 'Read' : 'Open' }}</button>
                    </form>
                @empty
                    <p class="muted">No admin alerts yet.</p>
                @endforelse
            </div>
        </section>
    @else
        <section class="grid two">
            <div class="panel">
                <h2>Incoming trade requests</h2>
                @forelse($incomingTrades as $trade)
                    <div class="row">
                        <span>{{ $trade->requester->username }} wants {{ $trade->item->name }}</span>
                        <span class="badge">{{ $trade->status }}</span>
                    </div>
                @empty
                    <p class="muted">No incoming requests.</p>
                @endforelse
            </div>
            <div class="panel">
                <div class="panel-title-row">
                    <h2>Notifications</h2>
                    <a href="{{ route('notifications.index') }}">View all</a>
                </div>
                @forelse($notifications as $notification)
                    <form method="POST" action="{{ route('notifications.update', $notification) }}" class="row">
                        @csrf @method('PATCH')
                        <span>{{ $notification->title }}</span>
                        <button class="link-button">{{ $notification->read_at ? 'Read' : 'Open' }}</button>
                    </form>
                @empty
                    <p class="muted">No notifications yet.</p>
                @endforelse
            </div>
        </section>
    @endif
@endsection
