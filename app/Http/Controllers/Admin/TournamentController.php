<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
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
}