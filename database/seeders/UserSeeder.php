<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('ja_JP');

        // universitiesテーブルの実際の大学数を取得
        $universityIds = DB::table('universities')->pluck('id')->toArray();

        $users = [];

        foreach ($universityIds as $universityId) {
            // 各大学でのuniversity_player_numberを管理するための配列
            $usedPlayerNumbers = [];

            // 男性選手30名を作成
            for ($i = 0; $i < 20; $i++) {
                // university_player_numberをランダム生成（重複しないように）
                do {
                    $universityPlayerNumber = rand(1, 9999);
                } while (in_array($universityPlayerNumber, $usedPlayerNumbers));

                $usedPlayerNumbers[] = $universityPlayerNumber;

                // player_numberを生成（gender=male なので最初の桁は0）
                $playerNumber = sprintf(
                    '1%02d%04d',
                    $universityId,
                    $universityPlayerNumber
                );

                // emailの生成（50%の確率でnull）
                $email = rand(0, 1) ? $faker->safeEmail : null;

                $users[] = [
                    'player_number' => (int)$playerNumber,
                    'university_id' => $universityId,
                    'university_player_number' => $universityPlayerNumber,
                    'name' => $faker->lastName . ' ' . $faker->firstNameMale,
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'gender' => 'male',
                    'grade' => rand(1, 6),
                    'years_enrolled' => rand(1, 4),
                    'is_stem' => rand(1, 10) > 1, // 90%がtrue、10%がfalse
                    'singles_points' => rand(0, 300),
                    'doubles_points' => rand(0, 300),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // 女性選手20名を作成
            for ($i = 0; $i < 15; $i++) {
                // university_player_numberをランダム生成（重複しないように）
                do {
                    $universityPlayerNumber = rand(1, 9999);
                } while (in_array($universityPlayerNumber, $usedPlayerNumbers));

                $usedPlayerNumbers[] = $universityPlayerNumber;

                // player_numberを生成（gender=female なので最初の桁は1）
                $playerNumber = sprintf(
                    '2%02d%04d',
                    $universityId,
                    $universityPlayerNumber
                );

                // emailの生成（50%の確率でnull）
                $email = rand(0, 1) ? $faker->safeEmail : null;

                $users[] = [
                    'player_number' => (int)$playerNumber,
                    'university_id' => $universityId,
                    'university_player_number' => $universityPlayerNumber,
                    'name' => $faker->lastName . ' ' . $faker->firstNameFemale,
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'gender' => 'female',
                    'grade' => rand(1, 6),
                    'years_enrolled' => rand(1, 4),
                    'is_stem' => rand(1, 10) > 1, // 90%がtrue、10%がfalse
                    'singles_points' => rand(0, 300),
                    'doubles_points' => rand(0, 300),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // バッチ挿入でパフォーマンスを向上（チャンクに分割）
        $chunks = array_chunk($users, 100);
        foreach ($chunks as $chunk) {
            DB::table('users')->insert($chunk);
        }
    }
}
