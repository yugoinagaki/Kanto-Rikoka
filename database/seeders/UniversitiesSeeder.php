<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UniversitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $universities = [
            ['name' => '慶應義塾大学矢上', 'boys_division' => 1, 'girls_division' => 1],
            ['name' => '東京理科大学', 'boys_division' => 1, 'girls_division' => 1],
            ['name' => '明治大学', 'boys_division' => 1, 'girls_division' => 1],
            ['name' => '早稲田大学', 'boys_division' => 1, 'girls_division' => 2],
            ['name' => '北里大学', 'boys_division' => 2, 'girls_division' => 2],
            ['name' => '東京都市大学', 'boys_division' => 2, 'girls_division' => 4],
            ['name' => '芝浦工業大学', 'boys_division' => 2, 'girls_division' => 6],
            ['name' => '工学院大学', 'boys_division' => 2, 'girls_division' => 9],
            ['name' => '青山学院大学', 'boys_division' => 3, 'girls_division' => 1],
            ['name' => '東京農工大学', 'boys_division' => 3, 'girls_division' => 3],
            ['name' => '東京科学大学', 'boys_division' => 3, 'girls_division' => 5],
            ['name' => '東京電機大学千住', 'boys_division' => 3, 'girls_division' => null],
            ['name' => '日本大学駿河台', 'boys_division' => 4, 'girls_division' => 4],
            ['name' => '日本大学生産工', 'boys_division' => 4, 'girls_division' => 5],
            ['name' => '日本大学習志野', 'boys_division' => 4, 'girls_division' => 6],
            ['name' => '電気通信大学', 'boys_division' => 4, 'girls_division' => 7],
            ['name' => '東京都立大学', 'boys_division' => 5, 'girls_division' => 3],
            ['name' => '東邦大学', 'boys_division' => 5, 'girls_division' => 4],
            ['name' => '成蹊大学', 'boys_division' => 5, 'girls_division' => 7],
            ['name' => '東京電機大学鳩山', 'boys_division' => 5, 'girls_division' => null],
            ['name' => '東京薬科大学', 'boys_division' => 6, 'girls_division' => 2],
            ['name' => '麻布大学', 'boys_division' => 6, 'girls_division' => 3],
            ['name' => '東洋大学川越', 'boys_division' => 6, 'girls_division' => 8],
            ['name' => '神奈川工科大学', 'boys_division' => 6, 'girls_division' => null],
            ['name' => '防衛大学校', 'boys_division' => 7, 'girls_division' => 2],
            ['name' => '千葉大学薬学部', 'boys_division' => 7, 'girls_division' => 7],
            ['name' => '東京工科大学', 'boys_division' => 7, 'girls_division' => 7],
            ['name' => '千葉工業大学', 'boys_division' => 7, 'girls_division' => 9],
            ['name' => '明治薬科大学', 'boys_division' => 8, 'girls_division' => 3],
            ['name' => '玉川大学', 'boys_division' => 8, 'girls_division' => null],
            ['name' => '東京海洋大学品川', 'boys_division' => 8, 'girls_division' => null],
            ['name' => '法政大学', 'boys_division' => 8, 'girls_division' => null],
            ['name' => '星薬科大学', 'boys_division' => 9, 'girls_division' => 4],
            ['name' => '慶應義塾大学薬学部', 'boys_division' => 9, 'girls_division' => 5],
            ['name' => '東京工芸大学', 'boys_division' => 9, 'girls_division' => 9],
            ['name' => '筑波大学', 'boys_division' => 9, 'girls_division' => null],
            ['name' => '立教大学', 'boys_division' => 10, 'girls_division' => 8],
            ['name' => '日本大学薬学部', 'boys_division' => 10, 'girls_division' => 8],
            ['name' => '中央大学', 'boys_division' => 10, 'girls_division' => 10],
            ['name' => '東京海洋大学越中島', 'boys_division' => 10, 'girls_division' => null],
            ['name' => '日本獣医生命科学大学', 'boys_division' => 11, 'girls_division' => 6],
            ['name' => '足利大学', 'boys_division' => 11, 'girls_division' => 10],
            ['name' => '日本工業大学', 'boys_division' => 11, 'girls_division' => null],
            ['name' => '帝京大学薬学部', 'boys_division' => 12, 'girls_division' => 8],
            ['name' => '横浜薬科大学', 'boys_division' => 12, 'girls_division' => 9],
            ['name' => '昭和大学薬学部', 'boys_division' => 12, 'girls_division' => 10],
            ['name' => '東京電機大学', 'boys_division' => null, 'girls_division' => 5],
            ['name' => '東京海洋大学', 'boys_division' => null, 'girls_division' => 6],
        ];

        DB::table('universities')->insert($universities);
    }
}
