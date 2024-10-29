<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'ファッション'
        ];
        DB::table('categories')->insert($param);

        $param = [
            'name' => 'ゲーム'
        ];
        DB::table('categories')->insert($param);

        $param = [
            'name' => 'ホビー'
        ];
        DB::table('categories')->insert($param);

        $param = [
            'name' => '家具'
        ];
        DB::table('categories')->insert($param);

        $param = [
            'name' => 'ハンドメイド'
        ];
        DB::table('categories')->insert($param);
    }
}
