<?php

namespace Tests\Feature;

use App\Exceptions\InvalidGameException;
use App\Models\Game;
use App\Models\Player;
use App\Services\GameService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameTest extends TestCase
{
    use RefreshDatabase;
    protected GameService $gameService;

    /**
     * @var Player
     */
    protected Player $playerOne;

    /**
     * @var Player
     */
    protected Player $playerTwo;
    protected function setUp(): void
    {
        parent::setUp();
        $this->gameService = new GameService();
        $this->playerOne = Player::factory()->create();
        $this->playerTwo = Player::factory()->create();

    }
    /**
     * Test that when a new game is started a new instance of a Game is created.
     */
    public function test_start_new_game(): void
    {
        $game = $this->gameService->initGame($this->playerOne->id, $this->playerOne->id);
        $this->assertModelExists($game);
    }

    /**
     * Test the isComplete() function
     * @return void
     */
    public function test_game_complete_status(): void
    {
        //Test isComplete == false
        $game = Game::factory()->create([
            'status' => "in_progress",
            'player_one_id' => $this->playerOne->id,
            'player_two_id' => $this->playerTwo->id,
        ]);
        $this->assertFalse($this->gameService->isComplete($game));

        //Test isComplete == true
        $game = Game::factory()->create([
            'status' => "is_complete",
            'player_one_id' => $this->playerOne->id,
            'player_two_id' => $this->playerTwo->id,
        ]);
        $this->assertTrue($this->gameService->isComplete($game));
    }

    /**
     * @return void
     */
    public function test_scoreboard(): void
    {
        $game = Game::factory()->create([
            'player_one_id' => $this->playerOne->id,
            'player_two_id' => $this->playerTwo->id,
            'player_one_points' => 0,
            'player_two_points' => 0,
        ]);
        $scoreboard = $this->gameService->scoreboard($game);
        $this->assertEquals("Love All", $scoreboard);

        //Test Deuce
        $game = Game::factory()->create([
            'player_one_id' => $this->playerOne->id,
            'player_two_id' => $this->playerTwo->id,
            'player_one_points' => 3,
            'player_two_points' => 3,
        ]);
        $scoreboard = $this->gameService->scoreboard($game);
        $this->assertEquals("Deuce", $scoreboard);

        //Test Advantage
        $game = Game::factory()->create([
            'player_one_id' => $this->playerOne->id,
            'player_two_id' => $this->playerTwo->id,
            'player_one_points' => 4,
            'player_two_points' => 3,
        ]);

        $scoreboard = $this->gameService->scoreboard($game);
        $this->assertEquals("Advantage Player One", $scoreboard);

        $game = Game::factory()->create([
            'player_one_id' => $this->playerOne->id,
            'player_two_id' => $this->playerTwo->id,
            'player_one_points' => 3,
            'player_two_points' => 4,
        ]);
        $scoreboard = $this->gameService->scoreboard($game);
        $this->assertEquals("Advantage Player Two", $scoreboard);

        //Test Win
        $game = Game::factory()->create([
            'player_one_id' => $this->playerOne->id,
            'player_two_id' => $this->playerTwo->id,
            'player_one_points' => 4,
            'player_two_points' => 7,
        ]);

        $scoreboard = $this->gameService->scoreboard($game);
        $this->assertEquals("Won by Player Two", $scoreboard);
    }

    /**
     * @return void
     * @throws InvalidGameException
     */
    public function test_game_already_complete(): void
    {
        $game = Game::factory()->create([
            'status' => "is_complete",
            'player_one_id' => $this->playerOne->id,
            'player_two_id' => $this->playerTwo->id,
            'player_one_points' => 4,
            'player_two_points' => 6,

        ]);

        $this->expectException(InvalidGameException::class);
        $this->expectExceptionMessage('Game has already been completed');
        $this->gameService->scorePoint($game, $this->playerOne, 2);
    }

    /**
     * Covers - playerOnePoint()
     * @throws InvalidGameException
     */
    public function test_player_one_score(): void
    {
        $game = Game::factory()->create([
            'status' => "in_progress",
            'player_one_id' => $this->playerOne->id,
            'player_two_id' => $this->playerTwo->id,
            'player_one_points' => 1,
            'player_two_points' => 1,
        ]);

        $this->gameService->scorePoint($game, $this->playerOne, 2);
        $this->assertEquals(3, $game->player_one_points);
    }

    /**
     * Covers - playerTwoPoint
     * @throws InvalidGameException
     */
    public function test_player_two_score(): void
    {
        $game = Game::factory()->create([
            'status' => "in_progress",
            'player_one_id' => $this->playerOne->id,
            'player_two_id' => $this->playerTwo->id,
            'player_one_points' => 1,
            'player_two_points' => 2,
        ]);

        $this->gameService->scorePoint($game, $this->playerTwo, 3);
        $this->assertEquals(5, $game->player_two_points);
        $this->assertEquals('is_complete', $game->status);
    }
}
