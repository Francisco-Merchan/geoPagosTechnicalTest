<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function games()
    {
        return $this->hasMany(Game::class)->where(function ($query) {
            $query->where('player_1', $this->id)
                  ->orWhere('player_2', $this->id);
        });
    }
    
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public static function newPlayer($data, $tournament)
    {
        return Player::create([
            'name' => $data['name'],
            "lastname" => $data['lastname'],
            'gender' => $tournament->type,
            "age" => $data['age'],
            "ability" => $data['ability'],
            "strength" => $data['strength'],
            "speed" => $data['speed'],
            "reaction_time" => $data['reaction_time'],
            'tournament_id' => $tournament->id
        ]);
    }

    public static function getSkills($player_id)
    {
        $player = Player::find($player_id);
        $skills = $player->ability + $player->strength + $player->speed + $player->reaction_time;
        $luck = rand(1, 10) / 100;
        $additional = $player->gender == 'F' ? ($player->reaction_time / 100) : (($player->strength + $player->speed)/100);
        return number_format($skills * (1 + $luck + $additional) , 3);
    }
}
