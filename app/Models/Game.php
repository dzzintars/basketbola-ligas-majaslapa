<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /** @use HasFactory<\Database\Factories\GameFactory> */
    use HasFactory;

    protected $fillable = [
        'home_team_id', 'away_team_id', 'home_score', 'away_score', 
        'location', 'game_date', 'season', 'status'
    ];

    protected $casts = [
        'game_date' => 'datetime',
    ];

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }
    

    public function stats()
    {
        return $this->hasMany(GamePlayer::class);
    }
}
