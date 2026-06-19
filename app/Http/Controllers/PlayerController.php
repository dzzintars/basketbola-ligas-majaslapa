<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PlayerController extends Controller
{
    public function index(Request $request)
    {
        $query = Player::with('team');

        if ($request->filled('team_id')) {
            $query->where('team_id', $request->team_id);
        }
        if ($request->filled('position')) {
            $query->where('position', $request->position);
        }

        $players = $query->paginate(6);
        $teams = Team::all();
        return view('players.index', compact('players', 'teams'));
    }

    public function show(Player $player)
    {
        $player->load('team');
        $games = collect(); 
        if ($player->team_id) {
            $games = Game::with(['homeTeam', 'awayTeam'])
                ->where('home_team_id', $player->team_id)
                ->orWhere('away_team_id', $player->team_id)
                ->orderBy('game_date', 'desc')
                ->get();
        }

        return view('players.show', compact('player', 'games'));
    }


    public function create()
    {
        Gate::authorize('admin');
        $teams = Team::all();
        return view('players.create', compact('teams'));
    }

    public function store(Request $request)
    {
        Gate::authorize('admin');
        $request->validate([
            'name' => 'required|string|max:255',
            'team_id' => 'required|exists:teams,id',
            'position' => 'required|string|max:10',
            'jersey_number' => 'required|integer|min:0|max:99',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('players', 'public');
        }

        Player::create([
            'name' => $request->name,
            'team_id' => $request->team_id,
            'position' => $request->position,
            'jersey_number' => $request->jersey_number,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('players.index')->with('success', 'Spēlētājs pievienots!');
    }


    public function edit(Player $player)
    {
        Gate::authorize('admin');
        $teams = Team::all();
        return view('players.edit', compact('player', 'teams'));
    }

    public function update(Request $request, Player $player)
    {
        Gate::authorize('admin');
        $request->validate([
            'name' => 'required|string|max:255',
            'team_id' => 'required|exists:teams,id',
            'position' => 'required|string|max:10',
            'jersey_number' => 'required|integer|min:0|max:99',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = $player->image_path;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('players', 'public');
        }

        $player->update([
            'name' => $request->name,
            'team_id' => $request->team_id,
            'position' => $request->position,
            'jersey_number' => $request->jersey_number,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('players.show', $player->id)->with('success', 'Spēlētājs atjaunināts!');
    }

    public function destroy(Player $player)
    {
        Gate::authorize('admin');
        $player->delete();
        return redirect()->route('players.index')->with('success', 'Spēlētājs izdzēsts!');
    }
}
