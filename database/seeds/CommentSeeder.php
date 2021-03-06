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
        $faker = app(Faker\Generator::class);

        $usersIds = DB::table('users')->pluck('id')->toArray();

        $posts = \App\Entity\Post::where('is_excellent','yes')->get();
        for($i = 0; $i < 100; $i++)
        {
            $post = $posts->random();
            factory(\App\Entity\Comment::class)->create([
                'user_id'   =>  $faker->randomElement($usersIds),
                'post_id'   =>  $post->id,
            ]);
            $post->increment('comment_count');
        }
    }
}
