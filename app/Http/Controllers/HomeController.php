<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $nextGames = Game::with(['homeTeam', 'awayTeam'])
            ->where('status', 'scheduled')
            ->orderBy('game_date', 'asc')
            ->take(5)
            ->get();

        $featuredPlayer = Player::with('team')->inRandomOrder()->first();

        $teams = Team::with(['homeGames' => function ($query) {
            $query->where('status', 'finished');
        }, 'awayGames' => function ($query) {
            $query->where('status', 'finished');
        }])->get();

        foreach ($teams as $team) {
            $wins = 0;
            $losses = 0;

            foreach ($team->homeGames as $game) {
                if ($game->home_score > $game->away_score) $wins++;
                elseif ($game->home_score < $game->away_score) $losses++;
            }

            foreach ($team->awayGames as $game) {
                if ($game->away_score > $game->home_score) $wins++;
                elseif ($game->away_score < $game->home_score) $losses++;
            }

            $team->games_played = $wins + $losses;
            $team->wins = $wins;
            $team->losses = $losses;
            $team->win_pct = $team->games_played > 0 ? round(($wins / $team->games_played) * 100, 1) : 0;
        }

        $standings = $teams->sortBy([
            ['wins', 'desc'],
            ['losses', 'asc'],
        ])->values();

        $usersCount = User::count();

        return view('home', compact('nextGames', 'featuredPlayer', 'standings', 'usersCount'));
    }
}
