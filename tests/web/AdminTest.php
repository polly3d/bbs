<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminTest extends TestCase
{
    /**
     * @test
     */
    public function 设为精华()
    {
        $postIds = \App\Entity\Post::pluck('id');
        $post = \App\Entity\Post::findOrFail($postIds->random());
        $user = \App\Entity\User::findOrFail($post->user_id);

        $post = $user->posts()->first();
        $route = route('toExcellent',$post->id);
        $this->actingAs($user);
        $this->visit($route)
            ->seePageIs('/');

        $adminUser = \App\Entity\User::findOrFail(1);
        $this->actingAs($adminUser)
            ->visit($route)
            ->seePageIs(route('post.show',$post->id));
        $post = \App\Entity\Post::findOrFail($post->id);
        $this->assertEquals('yes',$post->is_excellent);
    }
}
