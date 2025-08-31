<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\TournamentPointRule;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TournamentController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::orderBy('year', 'desc')
            ->orderBy('starts_on', 'desc')
            ->get();

        return Inertia::render('Admin/Tournaments/Index', [
            'tournaments' => $tournaments,
        ]);
    }

    public function create()
    {
        $tournamentPointRules = TournamentPointRule::orderBy('grade')->get();

        return Inertia::render('Admin/Tournaments/Create', [
            'tournamentPointRules' => $tournamentPointRules,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:2099',
            'starts_on' => 'nullable|date',
            'ends_on' => 'nullable|date|after_or_equal:starts_on',
            'categories' => 'nullable|array',
            'categories.*' => 'string|max:255',
            'tournament_point_rule_id' => 'nullable|exists:tournament_point_rules,id',
        ]);

        Tournament::create($validated);

        return redirect()->route('admin.tournaments.index')
            ->with('message', '大会を作成しました。');
    }

    public function show(Tournament $tournament)
    {
        return Inertia::render('Admin/Tournaments/Show', [
            'tournament' => $tournament,
        ]);
    }
}