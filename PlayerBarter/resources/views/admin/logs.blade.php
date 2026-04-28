@extends('layouts.app')

@section('content')
    <section class="section-head"><div><p class="eyebrow">Compliance</p><h1>Trade logs</h1></div></section>
    <section class="panel">
        @foreach($trades as $trade)
            <div class="row log">
                <span>#{{ $trade->id }} {{ $trade->item->name }} | {{ $trade->requester->username }} requested from {{ $trade->owner->username }}</span>
                <span class="badge">{{ $trade->status }} | {{ $trade->created_at->format('M d, Y H:i') }}</span>
            </div>
        @endforeach
        {{ $trades->links() }}
    </section>
@endsection
