<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UniversityController extends Controller
{
    public function index()
    {
        $universities = University::all();
        
        $boysUniversities = [];
        $girlsUniversities = [];
        
        foreach ($universities as $university) {
            if ($university->boys_league !== null) {
                if (!isset($boysUniversities[$university->boys_league])) {
                    $boysUniversities[$university->boys_league] = [];
                }
                $boysUniversities[$university->boys_league][] = $university;
            }
            
            if ($university->girls_league !== null) {
                if (!isset($girlsUniversities[$university->girls_league])) {
                    $girlsUniversities[$university->girls_league] = [];
                }
                $girlsUniversities[$university->girls_league][] = $university;
            }
        }
        
        // 各リーグ内で順位順にソート
        foreach ($boysUniversities as $league => $universities) {
            usort($boysUniversities[$league], function($a, $b) {
                return ($a->boys_rank ?? 999) <=> ($b->boys_rank ?? 999);
            });
        }
        
        foreach ($girlsUniversities as $league => $universities) {
            usort($girlsUniversities[$league], function($a, $b) {
                return ($a->girls_rank ?? 999) <=> ($b->girls_rank ?? 999);
            });
        }
        
        // リーグを数値順でソート
        ksort($boysUniversities, SORT_NUMERIC);
        ksort($girlsUniversities, SORT_NUMERIC);
        
        $isAdmin = request()->is('admin/*');
        
        return Inertia::render('Universities/Index', [
            'boysUniversities' => $boysUniversities,
            'girlsUniversities' => $girlsUniversities,
            'isAdmin' => $isAdmin,
        ]);
    }

    public function edit()
    {
        $universities = University::all();
        
        $boysUniversities = [];
        $girlsUniversities = [];
        
        foreach ($universities as $university) {
            if ($university->boys_league !== null) {
                if (!isset($boysUniversities[$university->boys_league])) {
                    $boysUniversities[$university->boys_league] = [];
                }
                $boysUniversities[$university->boys_league][] = $university;
            }
            
            if ($university->girls_league !== null) {
                if (!isset($girlsUniversities[$university->girls_league])) {
                    $girlsUniversities[$university->girls_league] = [];
                }
                $girlsUniversities[$university->girls_league][] = $university;
            }
        }
        
        // 各リーグ内で順位順にソート
        foreach ($boysUniversities as $league => $universities) {
            usort($boysUniversities[$league], function($a, $b) {
                return ($a->boys_rank ?? 999) <=> ($b->boys_rank ?? 999);
            });
        }
        
        foreach ($girlsUniversities as $league => $universities) {
            usort($girlsUniversities[$league], function($a, $b) {
                return ($a->girls_rank ?? 999) <=> ($b->girls_rank ?? 999);
            });
        }
        
        // リーグを数値順でソート
        ksort($boysUniversities, SORT_NUMERIC);
        ksort($girlsUniversities, SORT_NUMERIC);
        
        return Inertia::render('Universities/Edit', [
            'boysUniversities' => $boysUniversities,
            'girlsUniversities' => $girlsUniversities,
        ]);
    }

    public function update(Request $request)
    {
        $boysUniversities = $request->input('boysUniversities');
        $girlsUniversities = $request->input('girlsUniversities');
        
        // 男子の全体順位とリーグを更新
        $boysGlobalRank = 1;
        $sortedBoysLeagues = array_keys($boysUniversities);
        sort($sortedBoysLeagues, SORT_NUMERIC);
        
        foreach ($sortedBoysLeagues as $league) {
            $universities = $boysUniversities[$league];
            foreach ($universities as $universityData) {
                $university = University::find($universityData['id']);
                if ($university) {
                    $university->boys_rank = $boysGlobalRank;
                    $university->boys_league = $league; // リーグも更新
                    $university->save();
                    $boysGlobalRank++;
                }
            }
        }
        
        // 女子の全体順位とリーグを更新
        $girlsGlobalRank = 1;
        $sortedGirlsLeagues = array_keys($girlsUniversities);
        sort($sortedGirlsLeagues, SORT_NUMERIC);
        
        foreach ($sortedGirlsLeagues as $league) {
            $universities = $girlsUniversities[$league];
            foreach ($universities as $universityData) {
                $university = University::find($universityData['id']);
                if ($university) {
                    $university->girls_rank = $girlsGlobalRank;
                    $university->girls_league = $league; // リーグも更新
                    $university->save();
                    $girlsGlobalRank++;
                }
            }
        }
        
        return redirect()->route('admin.universities.index')->with('success', '順位を更新しました。');
    }
}