<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function player1()
    {
        return $this->belongsTo(Player::class, 'player_1');
    }

    public function player2()
    {
        return $this->belongsTo(Player::class, 'player_2');
    }

    public function winnerPlayer()
    {
        return $this->belongsTo(Player::class, 'winner');
    }

    public function round()
    {
        return $this->belongsTo(Round::class);
    }

    public static function newGame($players, $round_id)
    {
        return Game::create([
            'player_1' => $players[0]->id,
            'player_2' => $players[1]->id,
            'winner' => self::getWinner($players),
            'round_id' => $round_id
        ]);
    }

    public static function getWinner($players)
    {
        $player1_skills = Player::getSkills($players[0]->id);
        $player2_skills = Player::getSkills($players[1]->id);
        return $player1_skills > $player2_skills ? $players[0]->id : $players[1]->id;
    }
}
