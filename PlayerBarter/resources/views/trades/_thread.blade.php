<div class="trade-thread">
    <div class="thread-title">
        <span>Coordination thread</span>
        <span class="badge">{{ $trade->messages->count() }}</span>
    </div>

    <div class="trade-messages">
        @forelse($trade->messages as $message)
            <div @class(['trade-message' => true, 'own' => $message->user_id === auth()->id()])>
                <div class="message-meta">
                    <strong>{{ $message->user->username }}</strong>
                    <span>{{ $message->created_at->diffForHumans() }}</span>
                </div>
                <p>{{ $message->body }}</p>
            </div>
        @empty
            <p class="muted">No coordination messages yet.</p>
        @endforelse
    </div>

    @if(in_array($trade->status, ['pending', 'accepted'], true))
        <form method="POST" action="{{ route('trades.messages.store', $trade) }}" class="thread-reply">
            @csrf
            <textarea name="body" rows="2" maxlength="1000" placeholder="Coordinate payment, item transfer, lobby, schedule, or account details." required></textarea>
            <button class="button" type="submit">Send Message</button>
        </form>
    @else
        <p class="muted">This trade is closed, so the thread is read-only.</p>
    @endif
</div>
