@extends('layouts.app')

@section('content')
    <section class="form-shell form-shell-wide">
        <div class="form-header">
            <p class="eyebrow">Inventory</p>
            <h1>Edit trade item</h1>
            <p class="form-subtitle">Keep item details accurate so trade requests stay transparent.</p>
        </div>
        <form method="POST" action="{{ route('items.update', $item) }}" class="stack">
            @method('PUT')
            @include('items._form', ['button' => 'Update Item'])
        </form>
    </section>
@endsection
