@extends('layouts.app')

@section('content')
    <section class="section-head"><div><p class="eyebrow">Moderation</p><h1>Reports</h1></div></section>
    <section class="panel">
        @forelse($reports as $report)
            <form method="POST" action="{{ route('admin.reports.update', $report) }}" class="report">
                @csrf @method('PATCH')
                <div class="report-summary">
                    <strong>{{ $report->reason }}</strong>
                    <span class="badge">{{ $report->status }}</span>
                </div>
                <p>Reporter: {{ $report->reporter->username }} | User: {{ $report->reportedUser?->username ?: 'N/A' }} | Item: {{ $report->item?->name ?: 'N/A' }}</p>
                @if($report->reportedUser)
                    <p class="muted">Reported account status: {{ $report->reportedUser->status }}</p>
                @endif
                <p class="muted">{{ $report->details ?: 'No extra details were provided.' }}</p>
                <div class="form-grid moderation-fields">
                    <div class="field">
                        <label for="status-{{ $report->id }}">Review status</label>
                        <select id="status-{{ $report->id }}" name="status">
                            @foreach(['open', 'reviewing', 'resolved', 'dismissed'] as $status)
                                <option @selected($report->status === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if($report->reportedUser)
                        <div class="field">
                            <label for="account_action-{{ $report->id }}">Account action</label>
                            <select id="account_action-{{ $report->id }}" name="account_action">
                                <option value="none">No action</option>
                                <option value="warn">Send warning</option>
                                <option value="inactive">Inactivate account</option>
                            </select>
                        </div>
                    @endif
                    <div class="field field-wide">
                        <label for="admin_notes-{{ $report->id }}">Admin notes</label>
                        <input id="admin_notes-{{ $report->id }}" name="admin_notes" value="{{ $report->admin_notes }}" placeholder="Warning issued, resolved, or dismissed">
                    </div>
                    <div class="form-actions inline-actions">
                        <button class="button" type="submit">Update Report</button>
                    </div>
                </div>
            </form>
        @empty
            <p class="muted">No reports submitted yet.</p>
        @endforelse
        {{ $reports->links() }}
    </section>
@endsection
