<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Comment;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => '2',
            'item_id' => '1',
            'comment' => 'テストコメントです。'
        ];
        DB::table('comments')->insert($param);

        $param = [
            'user_id' => '2',
            'item_id' => '2',
            'comment' => 'テストコメントです。'
        ];
        DB::table('comments')->insert($param);

        Comment::factory()->count(50)->create();
    }
}