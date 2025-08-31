<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TournamentPointRule;
use Inertia\Inertia;

class RuleController extends Controller
{
    public function index()
    {
        // grade別のポイント表一覧を取得
        $grades = TournamentPointRule::orderBy('grade')
            ->pluck('grade');

        return Inertia::render('Admin/Rules/Index', [
            'grades' => $grades
        ]);
    }
}