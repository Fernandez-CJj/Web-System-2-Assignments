@extends('layouts.app')

@section('content')
    <section class="section-head">
        <div>
            <p class="eyebrow">Alerts</p>
            <h1>Notifications</h1>
            <p class="muted">Trade requests, status updates, completed trades, and moderation alerts appear here.</p>
        </div>
    </section>

    <section class="notification-list">
        @forelse($notifications as $notification)
            <article @class(['notification-card' => true, 'unread' => is_null($notification->read_at)])>
                <div>
                    <div class="notification-title">
                        @if(is_null($notification->read_at))
                            <span class="unread-dot"></span>
                        @endif
                        <h2>{{ $notification->title }}</h2>
                    </div>
                    <p>{{ $notification->body }}</p>
                    <span class="muted">{{ $notification->created_at->diffForHumans() }}</span>
                </div>
                <form method="POST" action="{{ route('notifications.update', $notification) }}">
                    @csrf @method('PATCH')
                    <button class="button {{ is_null($notification->read_at) ? 'primary' : '' }}" type="submit">
                        {{ is_null($notification->read_at) ? 'Open Alert' : 'Open' }}
                    </button>
                </form>
            </article>
        @empty
            <div class="panel">
                <p class="muted">No notifications yet.</p>
            </div>
        @endforelse
    </section>

    {{ $notifications->links() }}
@endsection
