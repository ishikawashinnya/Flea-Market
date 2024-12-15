<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
        $admin = User::firstOrcreate(
            ['email' => 'admin@example.com'],
            [
                'name' => '管理者',
                'password' => bcrypt('testadmin'),
                'email_verified_at' => now(),
            ]
        );

        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
        
        $user = User::firstOrcreate(
            ['email' => 'testuser@example.com'],
            [
                'name' => 'テストユーザー',
                'password' => bcrypt('testuser'),
                'email_verified_at' => now(),
            ]
        );
    }
}