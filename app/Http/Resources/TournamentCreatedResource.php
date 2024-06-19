<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TournamentCreatedResource extends JsonResource
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
            'message' => 'Successfully created tournament',
            'data' => [
                'id' => $this->id,
                'tournament_name' => $this->name,
                'type' => $this->type == 'F' ? 'Female' : 'Male',
                'year' => $this->year,
                'participants' => $this->participants
            ],
        ];
    }
}
