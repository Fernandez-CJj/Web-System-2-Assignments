<div class="trade-item-summary">
    <div class="trade-item-title">
        <div>
            <span class="field-label">Trade item</span>
            <h3>{{ $item->name }}</h3>
        </div>
        <span class="badge">{{ $item->availability_status }}</span>
    </div>

    @include('items._gallery', ['item' => $item, 'limit' => 4])

    <div class="trade-item-meta">
        <span>{{ $item->type }}</span>
        <span>{{ $item->game_category }}</span>
        <span>{{ $item->rarity }}</span>
    </div>

    <p>{{ $item->description ?: 'No description provided.' }}</p>
</div>
