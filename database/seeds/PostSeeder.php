<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Faker\Generator::class);
        $users = \App\Entity\User::pluck('id');
        $categories = \App\Entity\Category::pluck('id');
        $user_1 = factory(\App\Entity\Post::class,50)->make([
            'user_id'       =>  1,
            'category_id'   =>  $faker->randomElement($categories->toArray()),
        ]);

        $user_ohter = factory(\App\Entity\Post::class,50)->make([
            'user_id'   =>  $faker->randomElement($users->toArray()),
            'category_id'   =>  $faker->randomElement($categories->toArray()),
        ]);

        DB::table('posts')
            ->insert(array_merge($user_1->toArray(),$user_ohter->toArray()));
    }
}
