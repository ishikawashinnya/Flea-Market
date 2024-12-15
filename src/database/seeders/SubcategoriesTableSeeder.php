<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubcategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'レディース',
            'category_id' => '1'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => 'メンズ',
            'category_id' => '1'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => 'キッズ',
            'category_id' => '1'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => 'テレビゲーム',
            'category_id' => '2'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => 'トレーディングカード',
            'category_id' => '2'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => 'キャラクターグッズ',
            'category_id' => '2'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => '楽器・機材',
            'category_id' => '3'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => '模型・プラモデル',
            'category_id' => '3'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => 'アート用品',
            'category_id' => '3'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => 'ライト・照明',
            'category_id' => '4'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => '机・テーブル',
            'category_id' => '4'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => '寝具',
            'category_id' => '4'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => 'アクセサリー',
            'category_id' => '5'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => 'ぬいぐるみ',
            'category_id' => '5'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => '手芸素材・材料',
            'category_id' => '5'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => '服',
            'category_id' => '6'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => 'シューズ',
            'category_id' => '6'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => '寝具・家具',
            'category_id' => '6'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => '本',
            'category_id' => '7'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => '漫画',
            'category_id' => '7'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => '雑誌',
            'category_id' => '7'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => '野球',
            'category_id' => '8'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => 'サッカー',
            'category_id' => '8'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => 'ゴルフ',
            'category_id' => '8'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => 'アウトドア用品',
            'category_id' => '9'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => 'フィッシング',
            'category_id' => '9'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => '旅行用品',
            'category_id' => '9'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => '車',
            'category_id' => '10'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => 'バイク',
            'category_id' => '10'
        ];
        DB::table('subcategories')->insert($param);

        $param = [
            'name' => '自転車',
            'category_id' => '10'
        ];
        DB::table('subcategories')->insert($param);
    }
}
