<?php

namespace App\Services;

use App\Exceptions\InvalidGameException;
use App\Models\Game;
use App\Models\Player;
use App\Models\Point;

class GameService
{
    /**
     * @param int $point
     * @return string
     */
    private function pointValues(int $point): string
    {
        return match ($point) {
            1 => 'Fifteen',
            2 => 'Thirty',
            3 => 'Forty',
            default => 'Love',
        };
    }

    /**
     * Create a new Game instance
     *
     * @param int $player_one_id
     * @param int $player_two_id
     * @return Game
     */
    public function initGame(int $player_one_id, int $player_two_id): Game
    {
        $game = new Game;
        $game->status = 'in_progress';
        $game->player_one_id = $player_one_id;
        $game->player_two_id = $player_two_id;
        $game->save();
        return $game;
    }

    /**
     * @param Game $game
     * @return string
     */
    public function scoreboard(Game $game): string
    {
        if ($game->player_one_points === $game->player_two_points) {
            if ($game->player_one_points < 3 && $game->player_two_points < 3) {
                return  "{$this->pointValues($game->player_one_points)} All";
            }
            if ($game->player_one_points >= 3 && $game->player_two_points >= 3) {
                return  "Deuce";
            }
        }

        if ($game->player_one_points >= 3 && $game->player_two_points >= 3) {
            if (abs($game->player_one_points - $game->player_two_points) == 1) {
                //Check the max
                return
                    max($game->player_one_points, $game->player_two_points) == $game->player_one_points ?
                        "Advantage Player One" : "Advantage Player Two";
            }
        }

        if (
            ($game->player_one_points >= 4 || $game->player_two_points >= 4) &&
            abs($game->player_one_points - $game->player_two_points) >= 2
        ) {
            return max($game->player_one_points, $game->player_two_points) == $game->player_one_points ?
                "Won by Player One":"Won by Player Two";
        }
        return "{$this->pointValues($game->player_one_points)} - {$this->pointValues($game->player_one_points)}";
    }

    /**
     * @param Game $game
     * @param Player $player
     * @param int $score
     * @return string
     * @throws InvalidGameException
     */
    public function scorePoint(Game $game, Player $player, int $score): Game
    {
        if ($this->isComplete($game)) {
            throw new InvalidGameException("Game has already been completed");
        }

        ($game->player_one_id == $player->id) ?
            $this->playerOnePoint($game, $score) :
            $this->playerTwoPoint($game, $score);

        //Check if this completes the game
        if (
            ($game->player_one_points >= 4 || $game->player_two_points >= 4) &&
            abs($game->player_one_points - $game->player_two_points) >= 2
        ) {
            $game->status ='is_complete';
            $game->save();
        }

        return  $game;
    }

    /**
     * @param Game $game
     * @param int $score
     * @return void
     */
    public function playerOnePoint(Game $game, int $score): void
    {
        $game->player_one_points += $score;
        $game->save();
    }

    /**
     * @param Game $game
     * @param int $score
     * @return void
     */
    public function playerTwoPoint(Game $game, int $score): void
    {
        $game->player_two_points += $score;
        $game->save();
    }

    /**
     * @param Game $game
     * @return bool
     */
    public function isComplete(Game $game): bool
    {
        return match ($game->status) {
            'in_progress', 'cancelled' => false,
            default => true,
        };
    }
}
