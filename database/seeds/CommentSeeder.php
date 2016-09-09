<?php

use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Entity\Comment::class,10)->create([
            'user_id'   =>  1,
            'post_id'   =>  1,
        ]);
    }
}
