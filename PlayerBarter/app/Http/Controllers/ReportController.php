<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Models\Report;
use App\Models\TradeItem;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function create(Request $request): View
    {
        return view('reports.create', [
            'reportedUser' => $request->filled('user') ? User::find($request->integer('user')) : null,
            'item' => $request->filled('item') ? TradeItem::find($request->integer('item')) : null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $attributes = $request->validate([
            'reported_user_id' => ['nullable', 'exists:users,id'],
            'trade_item_id' => ['nullable', 'exists:trade_items,id'],
            'reason' => ['required', 'string', 'max:120'],
            'details' => ['nullable', 'string', 'max:1000'],
        ]);

        Report::create($attributes + ['reporter_id' => $request->user()->id]);

        User::where('role', 'admin')->each(function (User $admin) {
            AppNotification::create([
                'user_id' => $admin->id,
                'title' => 'New moderation report',
                'body' => 'A player submitted a report for admin review.',
                'link' => route('admin.reports'),
            ]);
        });

        return redirect()->route('dashboard')->with('status', 'Report submitted for review.');
    }
}
