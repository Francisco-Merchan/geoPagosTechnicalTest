<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Http\Requests\NewTournamentRequest;
use App\Http\Resources\RoundPlayedResource;
use App\Http\Resources\TournamentCreatedResource;
use App\Http\Resources\TournamentFinishedResource;
use App\Models\Game;
use App\Models\Player;
use App\Models\Round;
use App\Models\Tournament;

class TournamentController extends Controller
{

    public function createTournament(NewTournamentRequest $request)
    {
        try {

            $tournament = Tournament::newTournament($request);

            foreach ($request->participants as $participant) {
                Player::newPlayer($participant, $tournament);
            }
            
            return new TournamentCreatedResource($tournament);

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function newRound(Tournament $tournament)
    {

            if($tournament->winner) return new TournamentFinishedResource($tournament);

            $availablePlayers = $tournament->availablePlayers();

            $round = Round::newRound($tournament);

            $this->playGames($availablePlayers, $round);

            $tournament->setWinner($availablePlayers);

            return new RoundPlayedResource($round);

    }

    public function playGames($availablePlayers, $round)
    {

        foreach ($round->getPlayers($availablePlayers) as $players) {
            Game::newGame($players, $round->id);
        }

    }

}
