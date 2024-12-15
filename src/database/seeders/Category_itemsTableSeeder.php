<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category_item;
use App\Models\Item;

class Category_itemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'item_id' => '1',
            'category_id' => '1',
            'subcategory_id' => '1'
        ];
        DB::table('category_items')->insert($param);

        $param = [
            'item_id' => '2',
            'category_id' => '2',
            'subcategory_id' => '4'
        ];
        DB::table('category_items')->insert($param);

        Category_item::factory()->count(20)->create();
    }
}