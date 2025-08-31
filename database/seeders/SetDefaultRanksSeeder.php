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
        
        // ディビジョンごとに大学をグループ化
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
        
        // 男子の順位を設定（アルファベット順で1-4位）
        foreach ($boysUniversities as $division => $unis) {
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
        foreach ($girlsUniversities as $division => $unis) {
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