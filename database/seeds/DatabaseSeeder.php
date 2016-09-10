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


        DB::table('users')->truncate();
        DB::table('categories')->truncate();
        DB::table('posts')->truncate();
        DB::table('Comments')->truncate();
        DB::table('votes')->truncate();

        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(PostSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(PostVoteSeeder::class);
    }
}
