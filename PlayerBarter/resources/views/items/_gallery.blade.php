@php($images = $item->images ?? collect())

@if($images->isNotEmpty())
    <div class="item-gallery">
        @foreach($images->take($limit ?? 6) as $image)
            <button
                class="item-gallery-trigger"
                type="button"
                data-image-modal-trigger
                data-image-modal-src="{{ $image->url }}"
                data-image-modal-title="{{ $item->name }} image {{ $loop->iteration }}"
                aria-label="View {{ $item->name }} image {{ $loop->iteration }}"
            >
                <img src="{{ $image->url }}" alt="{{ $item->name }} image {{ $loop->iteration }}">
            </button>
        @endforeach
    </div>
@endif
