<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $sales = Sale::query()
            ->orderBy('sale_date')
            ->get();

        $monthly = $sales
            ->groupBy(fn (Sale $sale) => $sale->sale_date->format('M'))
            ->map(fn ($items, string $month) => [
                'month' => $month,
                'total' => round((float) $items->sum('amount'), 2),
                'orders' => (int) $items->sum('orders'),
            ])
            ->values();

        $channels = $sales
            ->groupBy('channel')
            ->map(fn ($items, string $channel) => [
                'channel' => $channel,
                'total' => round((float) $items->sum('amount'), 2),
            ])
            ->values();

        $regions = $sales
            ->groupBy('region')
            ->map(fn ($items, string $region) => [
                'region' => $region,
                'total' => round((float) $items->sum('amount'), 2),
                'orders' => (int) $items->sum('orders'),
            ])
            ->sortByDesc('total')
            ->values();

        $totalRevenue = (float) $sales->sum('amount');
        $totalOrders = (int) $sales->sum('orders');
        $bestMonth = $monthly->sortByDesc('total')->first();

        return view('dashboard', [
            'monthlyLabels' => $monthly->pluck('month')->values(),
            'monthlyTotals' => $monthly->pluck('total')->values(),
            'monthlyOrders' => $monthly->pluck('orders')->values(),
            'channelLabels' => $channels->pluck('channel')->values(),
            'channelTotals' => $channels->pluck('total')->values(),
            'regions' => $regions,
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'averageOrderValue' => $totalOrders > 0 ? $totalRevenue / $totalOrders : 0,
            'bestMonth' => $bestMonth,
        ]);
    }
}
