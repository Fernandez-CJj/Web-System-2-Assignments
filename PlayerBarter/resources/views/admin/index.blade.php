@extends('layouts.app')

@section('content')
    <section class="section-head">
        <div>
            <p class="eyebrow">Administration</p>
            <h1>Management panel</h1>
        </div>
        <div class="actions">
            <a class="button" href="{{ route('admin.reports') }}">Reports</a>
            <a class="button" href="{{ route('admin.logs') }}">Trade Logs</a>
        </div>
    </section>

    <section class="stats">
        @foreach($stats as $label => $value)
            <div class="stat"><strong>{{ $value }}</strong><span>{{ str_replace('_', ' ', $label) }}</span></div>
        @endforeach
    </section>

    <section class="grid two">
        <div class="panel">
            <h2>Manage users</h2>
            @foreach($users as $user)
                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="admin-row">
                    @csrf @method('PATCH')
                    <span class="admin-user">{{ $user->username }}</span>
                    <label class="compact-field"><span>Role</span><select name="role"><option @selected($user->role === 'player')>player</option><option @selected($user->role === 'admin')>admin</option></select></label>
                    <label class="compact-field"><span>Status</span><select name="status"><option @selected($user->status === 'active')>active</option><option @selected($user->status === 'warned')>warned</option><option @selected($user->status === 'inactive')>inactive</option><option @selected($user->status === 'suspended')>suspended</option></select></label>
                    <button class="button" type="submit">Save</button>
                </form>
            @endforeach
            {{ $users->links() }}
        </div>
        <div class="panel">
            <h2>Recent items</h2>
            @foreach($items as $item)
                <div class="row">
                    <span>{{ $item->name }} by {{ $item->user->username }}</span>
                    <span class="badge">{{ $item->availability_status }}</span>
                    <div class="actions">
                        @if($item->availability_status !== 'traded')
                            <form method="POST" action="{{ route('admin.items.status', $item) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="availability_status" value="{{ $item->availability_status === 'hidden' ? 'available' : 'hidden' }}">
                                <button class="button" type="submit">{{ $item->availability_status === 'hidden' ? 'Restore' : 'Hide' }}</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('items.destroy', $item) }}">
                            @csrf @method('DELETE')
                            <button class="button danger" type="submit">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
            {{ $items->links() }}
        </div>
    </section>
@endsection
