<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MyTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        //发贴最多的人 and 回复最多的人
        $usersByCreatePost = \App\Entity\User::withCount('posts')
            ->withCount('comments')
            ->get();

        foreach($usersByCreatePost as &$user)
        {
            $user->active_count = $user->comments_count + $user->posts_count;
        }

        $expected = $usersByCreatePost->sortByDesc('active_count')
            ->take(config('blog.active_user_number'));

        $this->assertEquals(config('blog.active_user_number'),$usersByCreatePost->count());

    }
}
