<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Models\Report;
use App\Models\TradeItem;
use App\Models\TradeRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    private function authorizeAdmin(): void
    {
        abort_unless(auth()->user()?->isAdmin(), 403);
    }

    public function index(): View
    {
        $this->authorizeAdmin();

        return view('admin.index', [
            'users' => User::latest()->paginate(8, ['*'], 'users_page')->withQueryString(),
            'items' => TradeItem::with('user')->latest()->paginate(8, ['*'], 'items_page')->withQueryString(),
            'stats' => [
                'users' => User::count(),
                'items' => TradeItem::count(),
                'pending_trades' => TradeRequest::where('status', 'pending')->count(),
                'completed_trades' => TradeRequest::where('status', 'completed')->count(),
                'open_reports' => Report::where('status', 'open')->count(),
            ],
        ]);
    }

    public function reports(): View
    {
        $this->authorizeAdmin();

        return view('admin.reports', [
            'reports' => Report::with(['reporter', 'reportedUser', 'item'])->latest()->paginate(10),
        ]);
    }

    public function updateReport(Request $request, Report $report): RedirectResponse
    {
        $this->authorizeAdmin();
        $attributes = $request->validate([
            'status' => ['required', 'in:open,reviewing,resolved,dismissed'],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
            'account_action' => ['nullable', 'in:none,warn,inactive'],
        ]);

        $accountAction = $attributes['account_action'] ?? 'none';
        unset($attributes['account_action']);
        $report->update($attributes);

        if ($accountAction !== 'none') {
            $reportedUser = $report->reportedUser;
            abort_unless($reportedUser, 422, 'This report has no reported account.');
            abort_if($reportedUser->id === auth()->id(), 422, 'You cannot moderate your own account.');

            if ($accountAction === 'warn') {
                $reportedUser->update(['status' => 'warned']);
                $this->notify(
                    $reportedUser->id,
                    'Moderation warning',
                    'An administrator reviewed a report involving your account and issued a warning. Please review your trade conduct.',
                    route('notifications.index')
                );
            }

            if ($accountAction === 'inactive') {
                $reportedUser->update(['status' => 'inactive']);
                $this->notify(
                    $reportedUser->id,
                    'Account inactivated',
                    'An administrator reviewed a report involving your account and inactivated your access.',
                    route('notifications.index')
                );
            }
        }

        $body = 'Your report status is now '.$report->status.'.';
        if ($report->admin_notes) {
            $body .= ' Admin note: '.$report->admin_notes;
        }

        $this->notify($report->reporter_id, 'Report '.$report->status, $body, route('notifications.index'));

        return back()->with('status', 'Report updated.');
    }

    public function updateUser(Request $request, User $user): RedirectResponse
    {
        $this->authorizeAdmin();
        abort_if($user->id === auth()->id(), 422, 'You cannot moderate your own account.');

        $attributes = $request->validate([
            'role' => ['required', 'in:player,admin'],
            'status' => ['required', 'in:active,warned,inactive,suspended'],
        ]);

        $user->update($attributes);

        return back()->with('status', 'User updated.');
    }

    public function updateItemStatus(Request $request, TradeItem $item): RedirectResponse
    {
        $this->authorizeAdmin();
        abort_if($item->availability_status === 'traded', 422, 'Completed trade items stay locked in history.');

        $attributes = $request->validate([
            'availability_status' => ['required', 'in:available,hidden'],
        ]);

        $item->update($attributes);

        return back()->with('status', 'Item moderation status updated.');
    }

    public function logs(): View
    {
        $this->authorizeAdmin();

        return view('admin.logs', [
            'trades' => TradeRequest::with(['item', 'requester', 'owner'])->latest()->paginate(25)->withQueryString(),
        ]);
    }

    private function notify(int $userId, string $title, string $body, string $link): void
    {
        AppNotification::create([
            'user_id' => $userId,
            'title' => $title,
            'body' => $body,
            'link' => $link,
        ]);
    }
}
