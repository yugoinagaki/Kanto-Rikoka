<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\University;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('university');
        
        // 男女別フィルタリング
        $gender = $request->query('gender', 'male'); // デフォルトは男子
        if (in_array($gender, ['male', 'female'])) {
            $query->where('gender', $gender);
        }
        
        // 大学別フィルタリング
        if ($request->filled('university_id')) {
            $query->where('university_id', $request->query('university_id'));
        }
        
        // 学年別フィルタリング
        if ($request->filled('grade')) {
            $query->where('grade', $request->query('grade'));
        }
        
        // 文系・理系フィルタリング
        if ($request->filled('is_stem')) {
            $query->where('is_stem', (bool) $request->query('is_stem'));
        }
        
        // 並び替え
        $sortBy = $request->query('sort_by', 'player_number');
        $sortOrder = $request->query('sort_order', 'asc');
        
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'asc';
        }
        
        switch ($sortBy) {
            case 'name':
                $query->orderBy('name', $sortOrder);
                break;
            case 'singles_points':
                $query->orderBy('singles_points', $sortOrder);
                break;
            case 'doubles_points':
                $query->orderBy('doubles_points', $sortOrder);
                break;
            case 'player_number':
            default:
                $query->orderBy('player_number', $sortOrder);
                break;
        }
        
        $users = $query->paginate(50);
        $universities = University::all();
        
        $isAdmin = $request->is('admin/*');
        
        return Inertia::render('Users/Index', [
            'users' => $users,
            'universities' => $universities,
            'isAdmin' => $isAdmin,
            'filters' => [
                'gender' => $gender,
                'university_id' => $request->query('university_id'),
                'grade' => $request->query('grade'),
                'is_stem' => $request->query('is_stem'),
                'sort_by' => $sortBy,
                'sort_order' => $sortOrder,
            ],
        ]);
    }

    public function adminIndex(Request $request)
    {
        return $this->index($request);
    }
}