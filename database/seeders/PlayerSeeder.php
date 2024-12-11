<?php

namespace Database\Seeders;

use App\Models\Player;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Player::factory()->create([
            'name' => 'Player One',
        ]);

        Player::factory()->create([
            'name' => 'Player Two',
        ]);
    }
}
