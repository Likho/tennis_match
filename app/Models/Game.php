<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    Relations\BelongsTo,
    Relations\HasMany,
    Relations\HasOne};

class Game extends Model
{
    use HasFactory;

    /**
     * @return HasOne
     */
    public function playerOne(): HasOne
    {
        return  $this->hasOne(Player::class, 'id', 'player_one_id');
    }

    /**
     * @return BelongsTo
     */
    public function playerTwo(): HasOne
    {
        return $this->hasOne(Player::class, 'id', 'player_two_id');
    }

//    public function formatterGames()
//    {
//        $this->
//    }
}
