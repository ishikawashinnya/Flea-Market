<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'テストユーザー',
            'email' => 'testuser@example.com',
            'password' => bcrypt('testuser'),
            'email_verified_at' => now()
        ];
        DB::table('users')->insert($param);
    }
}
