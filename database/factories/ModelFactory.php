<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(\App\Entity\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(\App\Entity\Category::class,function(Faker\Generator $faker){
    return [
        'name'  =>  $faker->name,
    ];
});


$factory->define(\App\Entity\Post::class,function(Faker\Generator $faker){
    $content_md = "#{$faker->sentence}\n\t##{$faker->sentence}";
    $categories = \App\Entity\Category::pluck('id')->toArray();
    return [
        'category_id'   =>  $faker->randomElement($categories),
        'title'         =>  $faker->sentence,
        'content_md'    =>  $faker->paragraph,
        'click_count'   =>  $faker->randomDigit,
        'is_excellent'  =>  $faker->randomElement(['yes','no']),
        'created_at'    =>  $faker->dateTimeBetween('-3 months'),
        'updated_at'    =>  $faker->dateTimeBetween('-10 days'),
    ];
});

$factory->define(\App\Entity\Comment::class,function(Faker\Generator $faker){
    $content_md = "#{$faker->sentence}\n\t##{$faker->sentence}";
    $time = $faker->dateTimeBetween('-2 months');
    return [
        'content_md'    =>  $content_md,
        'vote_count'    =>  $faker->randomDigit,
        'created_at'    =>  $time,
        'updated_at'    =>  $time,
    ];
});

$factory->define(\App\Entity\Vote::class,function(Faker\Generator $faker){
    $type = [\App\Entity\Post::class,\App\Entity\Comment::class];
    return [
        'voteable_id'   => $faker->numberBetween(1,10),
        'voteable_type' => $faker->randomElement($type),
    ];
});