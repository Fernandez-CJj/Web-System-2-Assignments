@csrf
<div class="form-grid">
    <div class="field field-wide">
        <label for="name">Item name</label>
        <input id="name" name="name" value="{{ old('name', $item->name) }}" placeholder="Neon Phantom Skin" required>
    </div>
    <div class="field">
        <label for="type">Item type</label>
        <select id="type" name="type" required>
            @foreach($types as $type)
                <option @selected(old('type', $item->type) === $type)>{{ $type }}</option>
            @endforeach
        </select>
    </div>
    <div class="field">
        <label for="game_category">Game category</label>
        @include('shared._game_multi_select', [
            'id' => 'game_category',
            'max' => 6,
            'name' => 'game_category',
            'placeholder' => 'Select item games',
            'preferredGames' => $preferredGames,
            'selected' => $item->game_category,
        ])
        <span class="field-hint">Select up to 6 games, then remove any chip you do not need.</span>
    </div>
    <div class="field">
        <label for="rarity">Rarity</label>
        <select id="rarity" name="rarity" required>
            @foreach($rarities as $rarity)
                <option @selected(old('rarity', $item->rarity ?: 'common') === $rarity)>{{ $rarity }}</option>
            @endforeach
        </select>
    </div>
    <div class="field">
        <label for="availability_status">Availability</label>
        <select id="availability_status" name="availability_status" required>
            @foreach($statuses as $status)
                <option @selected(old('availability_status', $item->availability_status ?: 'available') === $status)>{{ $status }}</option>
            @endforeach
        </select>
    </div>
    <div class="field field-wide">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="5" placeholder="Condition, notes, or trade expectations">{{ old('description', $item->description) }}</textarea>
        <span class="field-hint">Mention anything that helps another player evaluate the trade safely.</span>
    </div>
    <div class="field field-wide">
        <label for="item_images">Item images</label>
        <div class="image-upload" data-image-upload data-image-upload-max="6">
            <input id="item_images" type="file" name="item_images[]" accept="image/*" multiple data-image-upload-input>
            <div class="image-upload-preview" data-image-upload-preview aria-live="polite"></div>
        </div>
        <span class="field-hint">Add up to 6 images per listing. JPG, PNG, GIF, and WebP images are accepted.</span>
    </div>
    @if($item->exists && $item->images->isNotEmpty())
        <div class="field field-wide">
            <span class="field-label">Current images</span>
            <div class="existing-images">
                @foreach($item->images as $image)
                    <label class="existing-image-card">
                        <img src="{{ $image->url }}" alt="{{ $item->name }} image {{ $loop->iteration }}">
                        <span><input type="checkbox" name="remove_images[]" value="{{ $image->id }}"> Remove</span>
                    </label>
                @endforeach
            </div>
        </div>
    @endif
</div>
<div class="form-actions">
    <button class="button primary" type="submit">{{ $button }}</button>
    <a class="button" href="{{ route('items.index') }}">Cancel</a>
</div>
