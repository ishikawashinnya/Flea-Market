<?php

namespace Database\Factories;

use App\Models\Condition;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;
        $imageFiles = File::files(public_path('/img'));
        $randomImage = $imageFiles[array_rand($imageFiles)];
        $imageName = $randomImage->getFilename();
        $destinationPath = storage_path('app/public/item_images/' . $imageName);
        File::copy($randomImage, $destinationPath);
        $imgUrl = 'storage/item_images/' . $imageName;

        return [
            'name' => $faker->word(),
            'price' => $faker->numberBetween(100, 30000),
            'description' => $faker->realText(random_int(20,250)),
            'img_url' => $imgUrl,
            'user_id' => User::inRandomOrder()->first()->id,
            'condition_id' => Condition::inRandomOrder()->first()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}