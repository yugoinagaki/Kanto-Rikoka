<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\League;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LeagueController extends Controller
{
    public function index()
    {
        $leagues = League::orderBy('year', 'desc')
            ->orderBy('start_date', 'desc')
            ->get();

        return Inertia::render('Admin/Leagues/Index', [
            'leagues' => $leagues,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Leagues/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:2099',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        League::create($validated);

        return redirect()->route('admin.leagues.index')
            ->with('message', 'リーグを作成しました。');
    }

    public function show(League $league)
    {
        return Inertia::render('Admin/Leagues/Show', [
            'league' => $league,
        ]);
    }
}
