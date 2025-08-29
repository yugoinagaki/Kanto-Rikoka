<?php

namespace App\Http\Controllers;

use App\Models\University;
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
        
        ksort($boysUniversities);
        ksort($girlsUniversities);
        
        $isAdmin = request()->is('admin/*');
        
        return Inertia::render('Universities/Index', [
            'boysUniversities' => $boysUniversities,
            'girlsUniversities' => $girlsUniversities,
            'isAdmin' => $isAdmin,
        ]);
    }
}