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
            if ($university->boys_division !== null) {
                if (!isset($boysUniversities[$university->boys_division])) {
                    $boysUniversities[$university->boys_division] = [];
                }
                $boysUniversities[$university->boys_division][] = $university;
            }
            
            if ($university->girls_division !== null) {
                if (!isset($girlsUniversities[$university->girls_division])) {
                    $girlsUniversities[$university->girls_division] = [];
                }
                $girlsUniversities[$university->girls_division][] = $university;
            }
        }
        
        // 各リーグ内で順位順にソート
        foreach ($boysUniversities as $division => $universities) {
            usort($boysUniversities[$division], function($a, $b) {
                return ($a->boys_rank ?? 999) <=> ($b->boys_rank ?? 999);
            });
        }
        
        foreach ($girlsUniversities as $division => $universities) {
            usort($girlsUniversities[$division], function($a, $b) {
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
            if ($university->boys_division !== null) {
                if (!isset($boysUniversities[$university->boys_division])) {
                    $boysUniversities[$university->boys_division] = [];
                }
                $boysUniversities[$university->boys_division][] = $university;
            }
            
            if ($university->girls_division !== null) {
                if (!isset($girlsUniversities[$university->girls_division])) {
                    $girlsUniversities[$university->girls_division] = [];
                }
                $girlsUniversities[$university->girls_division][] = $university;
            }
        }
        
        // 各リーグ内で順位順にソート
        foreach ($boysUniversities as $division => $universities) {
            usort($boysUniversities[$division], function($a, $b) {
                return ($a->boys_rank ?? 999) <=> ($b->boys_rank ?? 999);
            });
        }
        
        foreach ($girlsUniversities as $division => $universities) {
            usort($girlsUniversities[$division], function($a, $b) {
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
        $sortedBoysDivisions = array_keys($boysUniversities);
        sort($sortedBoysDivisions, SORT_NUMERIC);
        
        foreach ($sortedBoysDivisions as $division) {
            $universities = $boysUniversities[$division];
            foreach ($universities as $universityData) {
                $university = University::find($universityData['id']);
                if ($university) {
                    $university->boys_rank = $boysGlobalRank;
                    $university->boys_division = $division; // リーグも更新
                    $university->save();
                    $boysGlobalRank++;
                }
            }
        }
        
        // 女子の全体順位とリーグを更新
        $girlsGlobalRank = 1;
        $sortedGirlsDivisions = array_keys($girlsUniversities);
        sort($sortedGirlsDivisions, SORT_NUMERIC);
        
        foreach ($sortedGirlsDivisions as $division) {
            $universities = $girlsUniversities[$division];
            foreach ($universities as $universityData) {
                $university = University::find($universityData['id']);
                if ($university) {
                    $university->girls_rank = $girlsGlobalRank;
                    $university->girls_division = $division; // リーグも更新
                    $university->save();
                    $girlsGlobalRank++;
                }
            }
        }
        
        return redirect()->route('admin.universities.index')->with('success', '順位を更新しました。');
    }
}