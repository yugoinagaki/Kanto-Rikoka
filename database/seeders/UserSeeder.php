<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 一般ユーザー5人
        User::factory()->create([
            'name' => '田中太郎',
            'email' => 'tanaka@example.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => '佐藤花子',
            'email' => 'sato@example.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => '鈴木一郎',
            'email' => 'suzuki@example.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => '高橋美咲',
            'email' => 'takahashi@example.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => '山田健太',
            'email' => 'yamada@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
