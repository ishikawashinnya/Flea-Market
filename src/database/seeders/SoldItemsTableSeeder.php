<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SoldItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => '3',
            'item_id' => '1'
        ];
        DB::table('sold_items')->insert($param);

        $param = [
            'user_id' => '2',
            'item_id' => '5'
        ];
        DB::table('sold_items')->insert($param);

        $param = [
            'user_id' => '2',
            'item_id' => '8'
        ];
        DB::table('sold_items')->insert($param);

        $param = [
            'user_id' => '2',
            'item_id' => '10'
        ];
        DB::table('sold_items')->insert($param);
    }
}