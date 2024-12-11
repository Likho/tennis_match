<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Player;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $players = Player::all();
        Game::factory()->create([
            'player_one_id' => $players[0]->id,
            'player_two_id' => $players[1]->id,
            'status' => 'in_progress',
        ]);
    }
}
