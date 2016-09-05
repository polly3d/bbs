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
        $user = new \App\User();
        $user->name = 'wang';
        $user->email = '1@1.com';
        $user->password = bcrypt('123456');
        $user->save();
        factory(\App\User::class,10)->create();

        DB::table('posts')->truncate();
        DB::table('comments')->truncate();
        factory(\App\Post::class,5)->create(['user_id'=>$user->id]);
        factory(\App\Post::class,5)->create(['user_id'=>2]);
        factory(\App\Comment::class,50)->create(['user_id'=>$user->id]);
        factory(\App\Comment::class,50)->create(['user_id'=>$user->id]);
    }
}
