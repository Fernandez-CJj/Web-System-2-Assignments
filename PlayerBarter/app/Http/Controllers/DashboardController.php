<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\TradeItem;
use App\Models\TradeRequest;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = auth()->user();

        return view('dashboard', [
            'totals' => [
                'users' => User::count(),
                'items' => TradeItem::count(),
                'trade_requests' => TradeRequest::count(),
                'reports' => Report::where('status', 'open')->count(),
            ],
            'myItems' => $user->items()->latest()->take(5)->get(),
            'incomingTrades' => $user->receivedTradeRequests()->with(['item', 'requester'])->latest()->take(6)->get(),
            'outgoingTrades' => $user->sentTradeRequests()->with(['item', 'owner'])->latest()->take(6)->get(),
            'notifications' => $user->notifications()->latest()->take(5)->get(),
        ]);
    }
}
