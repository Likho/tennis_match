<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Player;
use App\Services\GameService;
use Illuminate\Http\{JsonResponse, Request};
use Inertia\{Inertia, Response};

class GameController extends Controller
{
    private GameService $gameService;
    private Player  $player;
    private Game $game;

    public function __construct(GameService $gameService, Player $player, Game $game){
        $this->gameService = $gameService;
        $this->player = $player;
        $this->game = $game;
    }

    /**
     * Get all games
     * @return Response
     */
    public function index(): Response
    {
        $games = Game::with('playerOne')
            ->with('playerTwo')
            ->get();

        $players = Player::all();
        return Inertia::render('Game/Index', ['games' => $games, 'players' => $players]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function startGame(Request $request): JsonResponse
    {
        $request->validate([
            'player_one_id' => 'required|integer|exists:players,id',
            'player_two_id' => 'required|integer|exists:players,id|different:player_one_id',
        ]);

        try {
            $player_one = $this->player->find($request->input('player_one_id'));
            $player_two = $this->player->find($request->input('player_two_id'));

            $this->gameService->initGame($player_one->id, $player_two->id);
            return \response()->json(['success' => 'New game created!!']);
        } catch (\Exception $exception) {
            return \response()->json(['error' => $exception->getMessage()]);
        }
    }

    /**
     * Assign Points to a player
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function scorePoints(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'game_id' => 'required|integer|exists:games,id',
                'player_id' => 'required|integer|exists:players,id',
                'points' => 'required|integer|max:3',
            ]);

            //Assign Points
            $game = $this->game->find($request->input('game_id'));
            $player = $this->player->find($request->input('player_id'));
            $points = $request->input('points');
            $this->gameService->scorePoint($game, $player, $points);

            return \response()->json(['success' => "Points updated for {$player->name}"]);
        } catch (\Throwable $exception) {
            return \response()->json(['error' => $exception->getMessage()]);
        }
    }



}
