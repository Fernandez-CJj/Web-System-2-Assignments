<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase text-[#ff6b4a]">Sales analytics</p>
                <h2 class="text-2xl font-bold text-[#142824]">Sales Performance Dashboard</h2>
            </div>
            <p class="text-sm font-medium text-[#55706b]">Demo account: test@example.com</p>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-9rem)] bg-[#eef6f2] py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <section class="overflow-hidden rounded-lg bg-[#12343b] text-white shadow-sm">
                <div class="grid gap-6 p-6 lg:grid-cols-[1.5fr_1fr] lg:p-8">
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-semibold uppercase text-[#f8d66d]">2026 revenue signal</p>
                            <h1 class="mt-2 text-3xl font-bold sm:text-4xl">Monthly Sales Overview</h1>
                        </div>
                        <p class="max-w-2xl text-sm leading-6 text-[#d8eee8]">
                            Track revenue, order volume, sales channel mix, and regional performance from one focused view.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-lg border border-white/10 bg-white/10 p-4">
                            <p class="text-sm text-[#d8eee8]">Revenue</p>
                            <p class="mt-2 text-2xl font-bold">${{ number_format($totalRevenue, 0) }}</p>
                        </div>
                        <div class="rounded-lg border border-white/10 bg-white/10 p-4">
                            <p class="text-sm text-[#d8eee8]">Orders</p>
                            <p class="mt-2 text-2xl font-bold">{{ number_format($totalOrders) }}</p>
                        </div>
                        <div class="rounded-lg border border-white/10 bg-white/10 p-4">
                            <p class="text-sm text-[#d8eee8]">Average order</p>
                            <p class="mt-2 text-2xl font-bold">${{ number_format($averageOrderValue, 0) }}</p>
                        </div>
                        <div class="rounded-lg border border-white/10 bg-white/10 p-4">
                            <p class="text-sm text-[#d8eee8]">Best month</p>
                            <p class="mt-2 text-2xl font-bold">{{ $bestMonth['month'] ?? 'No data' }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="grid gap-6 lg:grid-cols-[2fr_1fr]">
                <div class="rounded-lg border border-[#d9e7e0] bg-white p-5 shadow-sm">
                    <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-[#142824]">Revenue Pulse</h3>
                            <p class="text-sm text-[#55706b]">Monthly revenue with order volume overlay</p>
                        </div>
                        <span class="w-fit rounded-full bg-[#fff3d1] px-3 py-1 text-sm font-semibold text-[#765400]">Line + bar</span>
                    </div>
                    <div class="relative h-80">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                <div class="overflow-hidden rounded-lg border border-[#d9e7e0] bg-white p-5 shadow-sm">
                    <div class="mb-5">
                        <h3 class="text-lg font-bold text-[#142824]">Channel Mix</h3>
                        <p class="text-sm text-[#55706b]">Revenue share by sales channel</p>
                    </div>
                    <div class="relative mx-auto h-72 w-full max-w-sm">
                        <canvas id="channelChart"></canvas>
                    </div>
                </div>
            </section>

            <section class="rounded-lg border border-[#d9e7e0] bg-white p-5 shadow-sm">
                <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-[#142824]">Regional Breakdown</h3>
                        <p class="text-sm text-[#55706b]">Sorted by total revenue</p>
                    </div>
                    <span class="w-fit rounded-full bg-[#e7f8ee] px-3 py-1 text-sm font-semibold text-[#176542]">{{ $regions->count() }} regions</span>
                </div>

                <div class="overflow-hidden rounded-lg border border-[#e4eee9]">
                    <table class="min-w-full divide-y divide-[#e4eee9]">
                        <thead class="bg-[#f6faf8]">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-bold uppercase text-[#55706b]">Region</th>
                                <th class="px-4 py-3 text-right text-xs font-bold uppercase text-[#55706b]">Revenue</th>
                                <th class="px-4 py-3 text-right text-xs font-bold uppercase text-[#55706b]">Orders</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#e4eee9] bg-white">
                            @forelse ($regions as $region)
                                <tr>
                                    <td class="px-4 py-4 text-sm font-semibold text-[#142824]">{{ $region['region'] }}</td>
                                    <td class="px-4 py-4 text-right text-sm text-[#334a45]">${{ number_format($region['total'], 0) }}</td>
                                    <td class="px-4 py-4 text-right text-sm text-[#334a45]">{{ number_format($region['orders']) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-4 py-6 text-sm text-[#55706b]" colspan="3">Run the database seeder to load demo sales.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const monthlyLabels = @json($monthlyLabels);
            const monthlyTotals = @json($monthlyTotals);
            const monthlyOrders = @json($monthlyOrders);
            const channelLabels = @json($channelLabels);
            const channelTotals = @json($channelTotals);
            const money = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
                maximumFractionDigits: 0,
            });
            const compactMoney = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
                notation: 'compact',
                maximumFractionDigits: 0,
            });

            const salesCanvas = document.getElementById('salesChart');
            const channelCanvas = document.getElementById('channelChart');

            if (!window.Chart || !salesCanvas || !channelCanvas) {
                return;
            }

            const salesGradient = salesCanvas.getContext('2d').createLinearGradient(0, 0, 0, 320);
            salesGradient.addColorStop(0, 'rgba(255, 107, 74, 0.32)');
            salesGradient.addColorStop(1, 'rgba(255, 107, 74, 0.02)');

            new window.Chart(salesCanvas, {
                data: {
                    labels: monthlyLabels,
                    datasets: [
                        {
                            type: 'line',
                            label: 'Revenue',
                            data: monthlyTotals,
                            borderColor: '#ff6b4a',
                            backgroundColor: salesGradient,
                            fill: true,
                            tension: 0.35,
                            pointBackgroundColor: '#12343b',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            yAxisID: 'revenue',
                        },
                        {
                            type: 'bar',
                            label: 'Orders',
                            data: monthlyOrders,
                            backgroundColor: '#31b889',
                            borderRadius: 8,
                            yAxisID: 'orders',
                        },
                    ],
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    layout: {
                        padding: {
                            left: 4,
                            right: 4,
                            top: 8,
                        },
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    plugins: {
                        legend: {
                            labels: {
                                boxWidth: 12,
                                color: '#334a45',
                                font: { weight: '600' },
                            },
                        },
                        tooltip: {
                            callbacks: {
                                label: (context) => {
                                    if (context.dataset.label === 'Revenue') {
                                        return `Revenue: ${money.format(context.parsed.y)}`;
                                    }

                                    return `Orders: ${context.parsed.y}`;
                                },
                            },
                        },
                    },
                    scales: {
                        revenue: {
                            beginAtZero: true,
                            grid: { color: '#edf4f0' },
                            ticks: {
                                color: '#55706b',
                                maxTicksLimit: 5,
                                callback: (value) => compactMoney.format(value),
                            },
                        },
                        orders: {
                            beginAtZero: true,
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            ticks: {
                                color: '#55706b',
                                maxTicksLimit: 5,
                            },
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#55706b' },
                        },
                    },
                },
            });

            new window.Chart(channelCanvas, {
                type: 'doughnut',
                data: {
                    labels: channelLabels,
                    datasets: [{
                        data: channelTotals,
                        backgroundColor: ['#12343b', '#ff6b4a', '#f8d66d', '#31b889'],
                        borderColor: '#ffffff',
                        borderWidth: 4,
                        hoverOffset: 8,
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    cutout: '66%',
                    radius: '82%',
                    layout: {
                        padding: 8,
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 10,
                                color: '#334a45',
                                font: { size: 12, weight: '600' },
                                padding: 14,
                                usePointStyle: true,
                            },
                        },
                        tooltip: {
                            callbacks: {
                                label: (context) => `${context.label}: ${money.format(context.parsed)}`,
                            },
                        },
                    },
                },
            });
        });
    </script>
</x-app-layout>
