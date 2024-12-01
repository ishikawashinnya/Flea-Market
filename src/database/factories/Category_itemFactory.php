<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category_item;
use App\Models\Item;

class Category_itemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'item_id' => Item::whereBetween('id', [3, 22])->inRandomOrder()->first()->id,
            'category_id' => random_int(1, 10),
        ];
    }
}