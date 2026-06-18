<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with(['homeTeam', 'awayTeam'])->orderBy('game_date', 'desc')->get();
        return view('games.index', compact('games'));
    }

    public function show(Game $game)
    {
        $game->load(['homeTeam', 'awayTeam']);
        return view('games.show', compact('game'));
    }

    public function create()
    {
        Gate::authorize('manage-games');
        $teams = Team::all();
        return view('games.create', compact('teams'));
    }

    public function store(Request $request)
    {
        Gate::authorize('manage-games');
        $validated = $request->validate([
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'game_date' => 'required|date',
            'location' => 'required|string|max:255',
            'season' => 'required|string|max:20',
            'status' => 'required|in:scheduled,finished',
            'home_score' => 'required_if:status,finished|prohibited_if:status,scheduled|nullable|integer|min:0',
            'away_score' => 'required_if:status,finished|prohibited_if:status,scheduled|nullable|integer|min:0|different:home_score',
        ]);

        Game::create($validated);

        return redirect()->route('games.index')->with('success', 'Spēle ieplānota!');
    }



    public function edit(Game $game)
    {
        Gate::authorize('manage-games');
        $teams = Team::all();
        return view('games.edit', compact('game', 'teams'));
    }

    public function update(Request $request, Game $game)
    {
        Gate::authorize('manage-games');
        $validated = $request->validate([
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'game_date' => 'required|date',
            'location' => 'required|string|max:255',
            'season' => 'required|string|max:20',
            'status' => 'required|in:scheduled,finished,canceled',
            'home_score' => 'required_if:status,finished|prohibited_if:status,scheduled|nullable|integer|min:0',
            'away_score' => 'required_if:status,finished|prohibited_if:status,scheduled|nullable|integer|min:0',
        ]);

        $game->update($validated);

        return redirect()->route('games.show', $game->id)->with('success', 'Spēles informācija atjaunināta!');
    }

    public function destroy(Game $game)
    {
        Gate::authorize('manage-games');
        $game->delete();
        return redirect()->route('games.index')->with('success', 'Spēle izdzēsta!');
    }
}
