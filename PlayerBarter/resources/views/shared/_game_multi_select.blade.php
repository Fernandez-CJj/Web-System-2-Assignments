@php
    $selectedGames = old($name, $selected ?? []);
    $selectedGames = is_array($selectedGames)
        ? $selectedGames
        : array_filter(array_map('trim', explode(',', $selectedGames)));

    $selectedGames = collect($selectedGames)
        ->filter(fn ($game) => in_array($game, $preferredGames, true))
        ->unique()
        ->values();

    $fieldId = $id ?? $name;
    $maxSelections = $max ?? 0;
@endphp

<div
    class="multi-select"
    data-multi-select
    data-name="{{ $name }}"
    data-max="{{ $maxSelections }}"
    data-placeholder="{{ $placeholder ?? 'Select games' }}"
>
    <button
        id="{{ $fieldId }}"
        class="multi-select-toggle"
        type="button"
        data-multi-select-toggle
        aria-haspopup="listbox"
        aria-expanded="false"
    >
        <span data-multi-select-label>{{ $selectedGames->isEmpty() ? ($placeholder ?? 'Select games') : $selectedGames->count().' selected' }}</span>
        <span class="multi-select-caret" aria-hidden="true"></span>
    </button>

    <div class="multi-select-menu" data-multi-select-menu role="listbox" aria-labelledby="{{ $fieldId }}" hidden>
        @foreach($preferredGames as $game)
            <button
                class="multi-select-option"
                type="button"
                data-multi-select-option
                data-value="{{ $game }}"
                role="option"
                aria-selected="{{ $selectedGames->contains($game) ? 'true' : 'false' }}"
            >
                <span>{{ $game }}</span>
                <span class="multi-select-check" aria-hidden="true">Selected</span>
            </button>
        @endforeach
    </div>

    <div class="selected-tags" data-multi-select-tags>
        @foreach($selectedGames as $game)
            <span class="selected-tag" data-multi-select-chip data-value="{{ $game }}">
                <input type="hidden" name="{{ $name }}[]" value="{{ $game }}">
                <span>{{ $game }}</span>
                <button type="button" data-multi-select-remove aria-label="Remove {{ $game }}">x</button>
            </span>
        @endforeach
    </div>
</div>
