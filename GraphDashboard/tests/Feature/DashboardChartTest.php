<?php

namespace Tests\Feature;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardChartTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_users_can_view_the_sales_graph_dashboard(): void
    {
        $user = User::factory()->create();

        Sale::query()->create([
            'amount' => 12840.75,
            'sale_date' => '2026-01-12',
            'channel' => 'Online',
            'region' => 'Metro Manila',
            'orders' => 138,
        ]);

        Sale::query()->create([
            'amount' => 15420.50,
            'sale_date' => '2026-02-10',
            'channel' => 'Retail',
            'region' => 'Central Luzon',
            'orders' => 164,
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response
            ->assertOk()
            ->assertSee('Sales Performance Dashboard')
            ->assertSee('salesChart', false)
            ->assertSee('channelChart', false)
            ->assertSee('Metro Manila');
    }
}
