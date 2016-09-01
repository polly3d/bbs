<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('posts')->truncate();
        DB::table('comments')->truncate();
        factory(\App\Post::class,100)->create();
        factory(\App\Comment::class,100)->create();
    }
}
