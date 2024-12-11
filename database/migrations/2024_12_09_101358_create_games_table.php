<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['in_progress', 'cancelled', 'is_complete'])->default('in_progress');
            $table->integer('player_one_points')->default(0);
            $table->integer('player_two_points')->default(0);
            $table->foreignId('player_one_id')->constrained('players');
            $table->foreignId('player_two_id')->constrained('players');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
