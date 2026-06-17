<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Pest\Plugins\Tia\Storage;

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
            if ($team->logo_path) {
                FacadesStorage::disk('public')->delete($team->logo_path);
            }
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
        if ($team->logo_path) {
            FacadesStorage::disk('public')->delete($team->logo_path);
        }

        $team->delete();

        return redirect()->route('teams.index')->with('success', 'Komanda izdzēsta!');
    }
}
