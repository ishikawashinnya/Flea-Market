<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesAndPermissionSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ConditionsTableSeeder::class);
        $this->call(ItemsTableSeeder::class);
        $this->call(LikesTableSeeder::class);
        $this->call(Category_itemsTableSeeder::class);
        $this->call(CommentsSeeder::class);
        $this->call(Sold_itemsTableSeeder::class);

        // \App\Models\User::factory(10)->create();
    }
}