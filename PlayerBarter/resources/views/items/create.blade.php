@extends('layouts.app')

@section('content')
    <section class="form-shell form-shell-wide">
        <div class="form-header">
            <p class="eyebrow">Inventory</p>
            <h1>Add trade item</h1>
            <p class="form-subtitle">Publish a clear listing so players can quickly judge game, rarity, and availability.</p>
        </div>
        <form method="POST" action="{{ route('items.store') }}" class="stack">
            @include('items._form', ['button' => 'List Item'])
        </form>
    </section>
@endsection
