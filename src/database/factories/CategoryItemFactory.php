<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category_item;
use App\Models\Item;
use App\Models\Category;
use App\Models\Subcategory;

class CategoryItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $usedItemIds = [];
        $itemIds = Item::whereBetween('id', [3, 22])->pluck('id')->toArray();
        $itemIds = array_diff($itemIds, $usedItemIds);
        shuffle($itemIds);
        $itemId = array_pop($itemIds);
        $usedItemIds[] = $itemId;
        $category = Category::inRandomOrder()->first();
        $subcategory = Subcategory::where('category_id', $category->id)
                                     ->inRandomOrder()
                                     ->first();
        $subcategory_id = $subcategory ? $subcategory->id : null;

        return [
            'item_id' => $itemId,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory_id,
        ];
    }
}