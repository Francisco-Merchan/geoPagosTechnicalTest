<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function participants()
    {
        return $this->hasMany(Player::class);
    }

    public function rounds()
    {
        return $this->hasMany(Round::class);
    }

    public static function newTournament($data)
    {
        return Tournament::create([
                'name' => $data->name,
                'type' => $data->female ? 'F' : 'M',
                'year' => Carbon::now()->year
        ]);
    }

    public function availablePlayers()
    {

        if($this->rounds->isEmpty()) return $this->participants;

        $winnerIds = $this->rounds->last()->games->pluck('winner')->filter();
        return Player::whereIn('id', $winnerIds)->get();
    }

    public function setWinner($availablePlayers)
    {
        if(count($availablePlayers) == 2)
        {
            $final_game = $this->rounds()->latest()->firstOrFail()->games()->latest()->first();
            $this->update(['winner' => $final_game->winner]);
        }
    }
}
