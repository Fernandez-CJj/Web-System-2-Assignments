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
        <input id="game_category" name="game_category" value="{{ old('game_category', $item->game_category) }}" placeholder="Valorant" required>
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
</div>
<div class="form-actions">
    <button class="button primary" type="submit">{{ $button }}</button>
    <a class="button" href="{{ route('items.index') }}">Cancel</a>
</div>
