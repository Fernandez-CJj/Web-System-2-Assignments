<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        return view('notifications.index', [
            'notifications' => auth()->user()
                ->notifications()
                ->latest()
                ->paginate(15)
                ->withQueryString(),
        ]);
    }

    public function update(AppNotification $notification): RedirectResponse
    {
        abort_unless($notification->user_id === auth()->id(), 403);
        $notification->update(['read_at' => now()]);

        return $notification->link ? redirect($notification->link) : back();
    }
}
