<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TournamentPoint;
use App\Models\TournamentPointRule;
use App\Http\Requests\StoreTournamentPointRequest;
use App\Http\Requests\UpdateTournamentPointRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class TournamentPointController extends Controller
{
    public function create()
    {
        return Inertia::render('Admin/Rules/TournamentPoints/Create');
    }

    public function store(StoreTournamentPointRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            // 1. tournament_point_rulesテーブルにレコードを作成
            $tournamentPointRule = TournamentPointRule::create([
                'grade' => $validated['grade']
            ]);

            // 2. tournament_pointsテーブルに複数レコードを作成
            $tournamentPoints = [];
            foreach ($validated['points'] as $point) {
                $tournamentPoints[] = [
                    'tournament_point_rule_id' => $tournamentPointRule->id,
                    'round' => $point['round'],
                    'points' => $point['points'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            TournamentPoint::insert($tournamentPoints);
        });

        return redirect()->route('admin.rules.index')
            ->with('success', 'ポイント表を登録しました。');
    }

    public function show($grade)
    {
        $tournamentPointRule = TournamentPointRule::where('grade', $grade)->first();

        $points = TournamentPoint::where('tournament_point_rule_id', $tournamentPointRule->id)
            ->orderBy('points', 'desc')
            ->get();

        return Inertia::render('Admin/Rules/TournamentPoints/Show', [
            'grade' => $grade,
            'points' => $points,
        ]);
    }

    public function update($grade, UpdateTournamentPointRequest $request)
    {
        $validated = $request->validated();
        
        $tournamentPointRule = TournamentPointRule::where('grade', $grade)->first();
        
        if (!$tournamentPointRule) {
            return redirect()->route('admin.rules.index')
                ->with('error', '指定されたポイント表が見つかりません。');
        }

        DB::transaction(function () use ($validated, $tournamentPointRule, $grade) {
            // 1. gradeの更新（変更された場合）
            if ($validated['grade'] !== $grade) {
                $tournamentPointRule->update(['grade' => $validated['grade']]);
            }

            // 2. 既存のポイントを削除
            TournamentPoint::where('tournament_point_rule_id', $tournamentPointRule->id)->delete();

            // 3. 新しいポイントを作成
            $tournamentPoints = [];
            foreach ($validated['points'] as $point) {
                $tournamentPoints[] = [
                    'tournament_point_rule_id' => $tournamentPointRule->id,
                    'round' => $point['round'],
                    'points' => $point['points'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            TournamentPoint::insert($tournamentPoints);
        });

        return redirect()->route('admin.tournament-points.show', ['grade' => $validated['grade']])
            ->with('success', 'ポイント表を更新しました。');
    }
}