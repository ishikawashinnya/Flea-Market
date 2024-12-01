<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'テスト出品データ1',
            'price' => '47000',
            'description' => "カラー：グレー\n\n新品\n商品の状態は良好です。傷もありません。\n\n購入後、即発送いたします。",
            'img_url' => '/img/AdobeStock_340381465.jpg',
            'user_id' => '2',
            'condition_id' => '1'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'テスト出品データ2。長文の場合の表示の確認。テスト出品データ。長文の場合の表示の確認。',
            'price' => '27000',
            'description' => "カラー：グレー\n\n新品商品の状態は良好です。\n傷もありません。\n\n購入後、即発送いたします。",
            'img_url' => '/img/chibakutusgata.jpg',
            'user_id' => '2',
            'condition_id' => '3'
        ];
        DB::table('items')->insert($param);

        Item::factory()->count(20)->create();
    }
}