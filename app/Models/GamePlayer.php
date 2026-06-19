<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamePlayer extends Model
{
     protected $fillable = [
        'player_id', 'game_id', 'points', 'rebounds', 'assists',
        'steals', 'blocks', 'turnovers', 'created_by'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
