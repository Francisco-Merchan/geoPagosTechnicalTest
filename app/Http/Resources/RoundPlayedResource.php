<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoundPlayedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'success' => true,
            'message' => 'Round played',
            'data' => [
                'tournament_name' => $this->tournament->name,
                'tournament_id' => $this->tournament->id,
                'round_id' => $this->id,
                'games' => $this->games->map(function ($game) {
                    return [
                        'game_id' => $game->id,
                        'player_1' =>  $game->player1->name. ' ' .$game->player1->lastname,
                        'player_2' =>$game->player2->name. ' ' .$game->player2->lastname,
                        'winner' => $game->winnerPlayer->name. ' ' .$game->winnerPlayer->lastname,
                        'date' => $game->date,
                    ];
                }),
            ],
        ];
    }
}
