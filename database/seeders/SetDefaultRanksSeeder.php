<?php

namespace Database\Seeders;

use App\Models\University;
use Illuminate\Database\Seeder;

class SetDefaultRanksSeeder extends Seeder
{
    public function run(): void
    {
        $universities = University::all();
        
        $boysUniversities = [];
        $girlsUniversities = [];
        
        // リーグごとに大学をグループ化
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
        
        // 男子の順位を設定（アルファベット順で1-4位）
        foreach ($boysUniversities as $league => $unis) {
            // 大学名でソート
            usort($unis, function($a, $b) {
                return strcmp($a->name, $b->name);
            });
            
            foreach ($unis as $index => $university) {
                $university->boys_rank = $index + 1;
                $university->save();
            }
        }
        
        // 女子の順位を設定（アルファベット順で1-4位）
        foreach ($girlsUniversities as $league => $unis) {
            // 大学名でソート
            usort($unis, function($a, $b) {
                return strcmp($a->name, $b->name);
            });
            
            foreach ($unis as $index => $university) {
                $university->girls_rank = $index + 1;
                $university->save();
            }
        }
        
        $this->command->info('Default ranks set successfully!');
    }
}