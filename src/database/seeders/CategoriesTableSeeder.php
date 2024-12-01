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
            'name' => 'ゲーム・おもちゃ・グッズ'
        ];
        DB::table('categories')->insert($param);

        $param = [
            'name' => 'ホビー・楽器・アート'
        ];
        DB::table('categories')->insert($param);

        $param = [
            'name' => '家具・インテリア'
        ];
        DB::table('categories')->insert($param);

        $param = [
            'name' => 'ハンドメイド'
        ];
        DB::table('categories')->insert($param);

        $param = [
            'name' => 'ベビー・キッズ'
        ];
        DB::table('categories')->insert($param);

        $param = [
            'name' => '本・雑誌・漫画'
        ];
        DB::table('categories')->insert($param);

        $param = [
            'name' => 'スポーツ'
        ];
        DB::table('categories')->insert($param);

        $param = [
            'name' => 'アウトドア・釣り・旅行用品'
        ];
        DB::table('categories')->insert($param);

        $param = [
            'name' => '車・バイク・転自車'
        ];
        DB::table('categories')->insert($param);
    }
}