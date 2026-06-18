<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        return view('teams.index', compact('teams'));
    }

    public function show(Team $team)
    {
        $team->load('players');
        return view('teams.show', compact('team'));
    }


    public function create()
    {
        Gate::authorize('admin');
        return view('teams.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('admin');

        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $logoPath = null;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        Team::create([
            'name' => $request->name,
            'city' => $request->city,
            'logo_path' => $logoPath,
        ]);

        return redirect()->route('teams.index')->with('success', 'Komanda izveidota!');
    }

    public function edit(Team $team)
    {
        Gate::authorize('admin');
        return view('teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        Gate::authorize('admin');
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $logoPath = $team->logo_path;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $team->update([
            'name' => $request->name,
            'city' => $request->city,
            'logo_path' => $logoPath,
        ]);

        return redirect()->route('teams.show', $team->id)->with('success', 'Komandas informācija atjaunināta!');
    }

    public function destroy(Team $team)
    {
        Gate::authorize('admin');
        $team->delete();
        return redirect()->route('teams.index')->with('success', 'Komanda izdzēsta!');
    }

    public function standings()
    {
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
        
        return view('teams.standings', compact('standings'));
    }
}
