@extends('layouts.app')

@section('content')
    <section class="form-shell">
        <div class="form-header">
            <p class="eyebrow">Moderation</p>
            <h1>Submit report</h1>
            <p class="form-subtitle">Flag suspicious users or listings so an admin can review the activity.</p>
        </div>
        <form method="POST" action="{{ route('reports.store') }}" class="stack">
            @csrf
            <input type="hidden" name="reported_user_id" value="{{ old('reported_user_id', $reportedUser?->id) }}">
            <input type="hidden" name="trade_item_id" value="{{ old('trade_item_id', $item?->id) }}">
            @if($reportedUser || $item)
                <div class="context-strip">
                    @if($reportedUser)<span class="context-chip">Player: {{ $reportedUser->username }}</span>@endif
                    @if($item)<span class="context-chip">Item: {{ $item->name }}</span>@endif
                </div>
            @endif
            <div class="field">
                <label for="reason">Reason</label>
                <input id="reason" name="reason" value="{{ old('reason') }}" placeholder="Suspicious listing, scam attempt, harassment" required>
            </div>
            <div class="field">
                <label for="details">Details</label>
                <textarea id="details" name="details" rows="5" placeholder="Add useful details for the moderation review">{{ old('details') }}</textarea>
            </div>
            <div class="form-actions">
                <button class="button primary" type="submit">Submit Report</button>
                <a class="button" href="{{ route('dashboard') }}">Cancel</a>
            </div>
        </form>
    </section>
@endsection
