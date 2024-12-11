<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory, Model,
    Relations\HasMany
};

class Player extends Model
{
    use HasFactory;

    /**
     * @return HasMany
     */
    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }
}
