<?php

use Illuminate\Database\Seeder;

class PostVoteSeeder extends Seeder
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
            $userId = $faker->randomElement($usersIds);
            $alreadyVote = $post->votes()
                ->where('user_id',$userId)
                ->count();
            if($alreadyVote)
                continue;
            $post->votes()->create([
                'user_id' => $userId,
            ]);
            $post->increment('vote_count',1);
        }
    }
}
