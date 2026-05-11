<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Demo Analyst',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ],
        );

        $sales = [
            ['2026-01-12', 12840.75, 'Online', 'Metro Manila', 138],
            ['2026-02-10', 15420.50, 'Retail', 'Central Luzon', 164],
            ['2026-03-16', 18790.00, 'Partner', 'Calabarzon', 188],
            ['2026-04-14', 16235.25, 'Online', 'Western Visayas', 171],
            ['2026-05-11', 21110.90, 'Retail', 'Metro Manila', 206],
            ['2026-06-18', 23640.15, 'Online', 'Central Visayas', 224],
            ['2026-07-09', 21880.40, 'Partner', 'Davao Region', 209],
            ['2026-08-13', 26425.80, 'Online', 'Metro Manila', 238],
            ['2026-09-17', 24970.35, 'Retail', 'Northern Mindanao', 226],
            ['2026-10-15', 30125.10, 'Partner', 'Calabarzon', 257],
            ['2026-11-12', 32740.60, 'Online', 'Central Luzon', 281],
            ['2026-12-10', 35890.95, 'Retail', 'Metro Manila', 304],
        ];

        foreach ($sales as [$saleDate, $amount, $channel, $region, $orders]) {
            Sale::query()->updateOrCreate(
                [
                    'sale_date' => $saleDate,
                    'channel' => $channel,
                ],
                [
                    'amount' => $amount,
                    'region' => $region,
                    'orders' => $orders,
                ],
            );
        }
    }
}
