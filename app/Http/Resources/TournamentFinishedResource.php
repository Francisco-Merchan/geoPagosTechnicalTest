<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TournamentFinishedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'success' => false,
            'message' => 'The tournament ended',
            'data' => [
                'tournament_name' => $this->name,
                'type' => $this->type == 'F' ? 'Female' : 'Male',
                'year' => $this->year,
                'winner' => $this->winner,
                'participants' => $this->participants,
                'rounds' => $this->rounds->map(function ($round) {
                    return [
                        'round_id' => $round->id,
                        'games' => $round->games->map(function ($game) {
                            return [
                                'game_id' => $game->id,
                                'player_1' => $game->player1->name. ' ' .$game->player1->lastname,
                                'player_2' => $game->player2->name. ' ' .$game->player2->lastname,
                                'winner' => $game->winnerPlayer->name. ' ' .$game->winnerPlayer->lastname,
                                'date' => $game->date,
                            ];
                        }),
                    ];
                }),
            ],
        ];
    }
}