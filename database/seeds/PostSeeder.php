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
        $users = \App\User::pluck('id');
        $categories = \App\Entity\Category::pluck('id');
        factory(\App\Entity\Post::class,100)->create([
            'user_id'   =>  $faker->randomElement($users->toArray()),
            'category_id'   =>  $faker->randomElement($categories->toArray()),
        ]);
    }
}
