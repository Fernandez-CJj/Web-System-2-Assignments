<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'username' => 'admin',
            'email' => 'admin@playerbarter.test',
            'role' => 'admin',
        ]);

        $players = User::factory(6)->create();

        foreach ($players as $player) {
            $player->items()->createMany([
                ['name' => 'Neon Phantom Skin', 'type' => 'Cosmetic Item', 'game_category' => 'Valorant', 'rarity' => 'epic', 'description' => 'Clean cosmetic skin ready for a fair swap.'],
                ['name' => 'Founders Avatar', 'type' => 'Digital Collectible', 'game_category' => 'Fortnite', 'rarity' => 'limited', 'description' => 'Limited profile collectible from an old event.'],
            ]);
        }
    }
}
