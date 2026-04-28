<?php

namespace Tests\Feature;

use App\Models\AppNotification;
use App\Models\Rating;
use App\Models\Report;
use App\Models\TradeItem;
use App\Models\TradeMessage;
use App\Models\TradeRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerBarterWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_players_can_request_accept_confirm_and_rate_a_trade(): void
    {
        $owner = User::factory()->create(['username' => 'owner']);
        $requester = User::factory()->create(['username' => 'requester']);
        $item = TradeItem::create([
            'user_id' => $owner->id,
            'name' => 'Arcade Champion Skin',
            'type' => 'Cosmetic Item',
            'game_category' => 'Valorant',
            'rarity' => 'rare',
            'availability_status' => 'available',
        ]);

        $this->actingAs($requester)->post(route('trades.store', $item), [
            'message' => 'Open to a fair swap.',
        ])->assertRedirect(route('trades.index'));

        $trade = $item->tradeRequests()->firstOrFail();
        $this->assertSame('pending', $trade->status);
        $this->assertDatabaseHas(AppNotification::class, ['user_id' => $owner->id, 'title' => 'New trade request']);

        $this->actingAs($owner)->patch(route('trades.update', $trade), ['status' => 'accepted'])->assertRedirect();
        $this->actingAs($requester)->patch(route('trades.confirm', $trade))->assertRedirect();
        $this->actingAs($owner)->patch(route('trades.confirm', $trade))->assertRedirect();

        $trade->refresh();
        $item->refresh();
        $this->assertSame('completed', $trade->status);
        $this->assertSame($requester->id, $item->user_id);
        $this->assertSame('traded', $item->availability_status);

        $this->actingAs($requester)->post(route('ratings.store', $trade), [
            'score' => 5,
            'comment' => 'Smooth coordination.',
        ])->assertRedirect();

        $this->assertDatabaseHas(Rating::class, [
            'trade_request_id' => $trade->id,
            'rater_id' => $requester->id,
            'rated_user_id' => $owner->id,
            'score' => 5,
        ]);
    }

    public function test_requester_can_cancel_a_pending_trade(): void
    {
        $owner = User::factory()->create();
        $requester = User::factory()->create();
        $item = TradeItem::create([
            'user_id' => $owner->id,
            'name' => 'Event Avatar',
            'type' => 'Collectible Item',
            'game_category' => 'Fortnite',
            'rarity' => 'limited',
            'availability_status' => 'available',
        ]);

        $this->actingAs($requester)->post(route('trades.store', $item));
        $trade = $item->tradeRequests()->firstOrFail();

        $this->actingAs($requester)->patch(route('trades.update', $trade), [
            'status' => 'cancelled',
        ])->assertRedirect();

        $this->assertSame('cancelled', $trade->refresh()->status);
        $this->assertSame('available', $item->refresh()->availability_status);
    }

    public function test_trade_participants_can_coordinate_with_messages(): void
    {
        $owner = User::factory()->create(['username' => 'seller']);
        $requester = User::factory()->create(['username' => 'buyer']);
        $outsider = User::factory()->create(['username' => 'outsider']);
        $item = TradeItem::create([
            'user_id' => $owner->id,
            'name' => 'Coordination Skin',
            'type' => 'Cosmetic Item',
            'game_category' => 'Valorant',
            'rarity' => 'rare',
            'availability_status' => 'available',
        ]);

        $this->actingAs($requester)->post(route('trades.store', $item), [
            'message' => 'Can transfer tonight through the in-game market.',
        ])->assertRedirect(route('trades.index'));

        $trade = $item->tradeRequests()->firstOrFail();
        $this->assertDatabaseHas(TradeMessage::class, [
            'trade_request_id' => $trade->id,
            'user_id' => $requester->id,
            'body' => 'Can transfer tonight through the in-game market.',
        ]);

        $this->actingAs($owner)->post(route('trades.messages.store', $trade), [
            'body' => 'Accepted, send the item after I confirm the lobby.',
        ])->assertRedirect();

        $this->assertDatabaseHas(TradeMessage::class, [
            'trade_request_id' => $trade->id,
            'user_id' => $owner->id,
            'body' => 'Accepted, send the item after I confirm the lobby.',
        ]);
        $this->assertDatabaseHas(AppNotification::class, [
            'user_id' => $requester->id,
            'title' => 'Trade message received',
        ]);

        $this->actingAs($outsider)->post(route('trades.messages.store', $trade), [
            'body' => 'I should not be part of this thread.',
        ])->assertForbidden();
    }

    public function test_trades_page_shows_ongoing_first_and_finished_behind_button(): void
    {
        $owner = User::factory()->create(['username' => 'historyseller']);
        $requester = User::factory()->create(['username' => 'historybuyer']);

        $pendingItem = TradeItem::create([
            'user_id' => $owner->id,
            'name' => 'Pending Trade Item',
            'type' => 'Cosmetic Item',
            'game_category' => 'Valorant',
            'rarity' => 'rare',
            'availability_status' => 'available',
        ]);
        $completedItem = TradeItem::create([
            'user_id' => $owner->id,
            'name' => 'Completed Trade Item',
            'type' => 'Cosmetic Item',
            'game_category' => 'Valorant',
            'rarity' => 'epic',
            'availability_status' => 'traded',
        ]);
        $cancelledItem = TradeItem::create([
            'user_id' => $owner->id,
            'name' => 'Cancelled Trade Item',
            'type' => 'Cosmetic Item',
            'game_category' => 'Valorant',
            'rarity' => 'limited',
            'availability_status' => 'available',
        ]);

        TradeRequest::create([
            'item_id' => $pendingItem->id,
            'requester_id' => $requester->id,
            'owner_id' => $owner->id,
            'status' => 'pending',
        ]);
        TradeRequest::create([
            'item_id' => $completedItem->id,
            'requester_id' => $requester->id,
            'owner_id' => $owner->id,
            'status' => 'completed',
            'completed_at' => now(),
        ]);
        TradeRequest::create([
            'item_id' => $cancelledItem->id,
            'requester_id' => $requester->id,
            'owner_id' => $owner->id,
            'status' => 'cancelled',
        ]);

        $this->actingAs($requester)
            ->get(route('trades.index'))
            ->assertOk()
            ->assertSee('Ongoing trades')
            ->assertSee('View Finished Trades (2)')
            ->assertSee($pendingItem->name)
            ->assertDontSee($completedItem->name)
            ->assertDontSee($cancelledItem->name);

        $this->actingAs($requester)
            ->get(route('trades.index', ['view' => 'finished']))
            ->assertOk()
            ->assertSee('Finished trades')
            ->assertSee('Back to Ongoing Trades (1)')
            ->assertSee($completedItem->name)
            ->assertSee($cancelledItem->name)
            ->assertDontSee($pendingItem->name);
    }

    public function test_trade_lists_are_paginated(): void
    {
        $owner = User::factory()->create();
        $requester = User::factory()->create();

        for ($i = 1; $i <= 6; $i++) {
            $item = TradeItem::create([
                'user_id' => $owner->id,
                'name' => 'Paginated Incoming Item '.$i,
                'type' => 'Cosmetic Item',
                'game_category' => 'Valorant',
                'rarity' => 'rare',
                'availability_status' => 'available',
            ]);

            TradeRequest::create([
                'item_id' => $item->id,
                'requester_id' => $requester->id,
                'owner_id' => $owner->id,
                'status' => 'pending',
            ]);
        }

        $this->actingAs($owner)
            ->get(route('trades.index'))
            ->assertOk()
            ->assertSee('Paginated Incoming Item 6')
            ->assertDontSee('Paginated Incoming Item 1')
            ->assertSee('incoming_page=2');

        $this->actingAs($owner)
            ->get(route('trades.index', ['incoming_page' => 2]))
            ->assertOk()
            ->assertSee('Paginated Incoming Item 1')
            ->assertDontSee('Paginated Incoming Item 6');
    }

    public function test_traded_items_are_hidden_from_public_active_listings(): void
    {
        $viewer = User::factory()->create();
        $player = User::factory()->create();
        $activeItem = TradeItem::create([
            'user_id' => $player->id,
            'name' => 'Visible Skin',
            'type' => 'Cosmetic Item',
            'game_category' => 'Valorant',
            'rarity' => 'rare',
            'availability_status' => 'available',
        ]);
        $tradedItem = TradeItem::create([
            'user_id' => $player->id,
            'name' => 'Completed Trade Skin',
            'type' => 'Cosmetic Item',
            'game_category' => 'Valorant',
            'rarity' => 'epic',
            'availability_status' => 'traded',
        ]);

        $this->actingAs($viewer)
            ->get(route('items.index'))
            ->assertSee($activeItem->name)
            ->assertDontSee($tradedItem->name);

        $this->actingAs($viewer)
            ->get(route('items.index', ['status' => 'traded']))
            ->assertSee($activeItem->name)
            ->assertDontSee($tradedItem->name);

        $this->actingAs($viewer)
            ->get(route('players.show', $player))
            ->assertSee($activeItem->name)
            ->assertDontSee($tradedItem->name);
    }

    public function test_admins_cannot_post_items_or_send_trade_requests(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $player = User::factory()->create();
        $item = TradeItem::create([
            'user_id' => $player->id,
            'name' => 'Player Only Listing',
            'type' => 'Cosmetic Item',
            'game_category' => 'Valorant',
            'rarity' => 'rare',
            'availability_status' => 'available',
        ]);

        $this->actingAs($admin)
            ->get(route('items.create'))
            ->assertForbidden();

        $this->actingAs($admin)
            ->post(route('items.store'), [
                'name' => 'Admin Listing',
                'type' => 'Cosmetic Item',
                'game_category' => 'Valorant',
                'rarity' => 'rare',
                'availability_status' => 'available',
            ])
            ->assertForbidden();

        $this->actingAs($admin)
            ->post(route('trades.store', $item))
            ->assertForbidden();

        $this->actingAs($admin)
            ->get(route('trades.index'))
            ->assertForbidden();
    }

    public function test_admins_can_moderate_but_not_edit_player_item_details(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $player = User::factory()->create();
        $item = TradeItem::create([
            'user_id' => $player->id,
            'name' => 'Moderated Listing',
            'type' => 'Cosmetic Item',
            'game_category' => 'Valorant',
            'rarity' => 'rare',
            'availability_status' => 'available',
        ]);

        $this->actingAs($admin)
            ->get(route('items.edit', $item))
            ->assertForbidden();

        $this->actingAs($admin)
            ->put(route('items.update', $item), [
                'name' => 'Admin Changed Listing',
                'type' => 'Cosmetic Item',
                'game_category' => 'Valorant',
                'rarity' => 'rare',
                'availability_status' => 'available',
            ])
            ->assertForbidden();

        $this->actingAs($admin)
            ->patch(route('admin.items.status', $item), [
                'availability_status' => 'hidden',
            ])
            ->assertRedirect();

        $this->assertSame('hidden', $item->refresh()->availability_status);
    }

    public function test_admin_can_warn_inactivate_reported_account_and_notify_reporter(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $reporter = User::factory()->create(['username' => 'reporter']);
        $reported = User::factory()->create(['username' => 'reported']);
        $report = Report::create([
            'reporter_id' => $reporter->id,
            'reported_user_id' => $reported->id,
            'reason' => 'Unsafe trade behavior',
            'details' => 'Requested payment outside agreed terms.',
        ]);

        $this->actingAs($admin)->patch(route('admin.reports.update', $report), [
            'status' => 'reviewing',
            'admin_notes' => 'Warning sent while reviewing.',
            'account_action' => 'warn',
        ])->assertRedirect();

        $this->assertSame('warned', $reported->refresh()->status);
        $this->assertDatabaseHas(AppNotification::class, [
            'user_id' => $reported->id,
            'title' => 'Moderation warning',
        ]);
        $this->assertDatabaseHas(AppNotification::class, [
            'user_id' => $reporter->id,
            'title' => 'Report reviewing',
        ]);

        $this->actingAs($admin)->patch(route('admin.reports.update', $report), [
            'status' => 'resolved',
            'admin_notes' => 'Account inactivated after review.',
            'account_action' => 'inactive',
        ])->assertRedirect();

        $this->assertSame('inactive', $reported->refresh()->status);
        $this->assertDatabaseHas(AppNotification::class, [
            'user_id' => $reported->id,
            'title' => 'Account inactivated',
        ]);
        $this->assertDatabaseHas(AppNotification::class, [
            'user_id' => $reporter->id,
            'title' => 'Report resolved',
        ]);

        $this->actingAs($reported)
            ->get(route('dashboard'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    public function test_registration_requires_a_strong_password(): void
    {
        $weakPassword = [
            'username' => 'newplayer',
            'email' => 'newplayer@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->from(route('register'))
            ->post(route('register'), $weakPassword)
            ->assertRedirect(route('register'))
            ->assertSessionHasErrors('password');

        $this->assertDatabaseMissing(User::class, ['username' => 'newplayer']);

        $strongPassword = [
            'username' => 'newplayer',
            'email' => 'newplayer@example.com',
            'password' => 'Player#123',
            'password_confirmation' => 'Player#123',
        ];

        $this->post(route('register'), $strongPassword)
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticated();
        $this->assertDatabaseHas(User::class, ['username' => 'newplayer']);
    }
}
