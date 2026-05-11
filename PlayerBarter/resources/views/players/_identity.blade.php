@php($size = $size ?? 'sm')

<span class="user-chip">
    @include('players._avatar', ['user' => $user, 'size' => $size])
    <a class="user-chip-name" href="{{ route('players.show', $user) }}">{{ $user->username }}</a>
</span>
