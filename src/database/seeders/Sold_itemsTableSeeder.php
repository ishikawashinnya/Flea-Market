<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Sold_itemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => '1',
            'item_id' => '1'
        ];
        DB::table('sold_items')->insert($param);

        $param = [
            'user_id' => '1',
            'item_id' => '2'
        ];
        DB::table('sold_items')->insert($param);

        $param = [
            'user_id' => '1',
            'item_id' => '3'
        ];
        DB::table('sold_items')->insert($param);

        $param = [
            'user_id' => '1',
            'item_id' => '4'
        ];
        DB::table('sold_items')->insert($param);

        $param = [
            'user_id' => '1',
            'item_id' => '5'
        ];
        DB::table('sold_items')->insert($param);
    }
}
