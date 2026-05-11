@php($size = $size ?? 'md')

@if($user->profile_photo_url)
    <button
        class="avatar-button"
        type="button"
        data-image-modal-trigger
        data-image-modal-src="{{ $user->profile_photo_url }}"
        data-image-modal-title="{{ $user->username }} profile picture"
        aria-label="View {{ $user->username }} profile picture"
    >
        <img class="avatar avatar-{{ $size }}" src="{{ $user->profile_photo_url }}" alt="{{ $user->username }} profile picture">
    </button>
@else
    <span class="avatar avatar-{{ $size }}" aria-label="{{ $user->username }} profile initials">{{ $user->initials() }}</span>
@endif
