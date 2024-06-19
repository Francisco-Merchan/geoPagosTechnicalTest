<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public static function newRound($tournament) 
    {
        return Round::create([
            'tournament_id' => $tournament->id,
            'date' => Carbon::now()->toDateString(),
        ]);
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function getPlayers($participants)
    {
        $players = [];
        for ($i = 0; $i < count($participants); $i += 2) {
            $players[] = [$participants[$i], $participants[$i + 1]];
        }
        return $players;
    }

}
