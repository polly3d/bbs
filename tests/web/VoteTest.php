<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VoteTest extends TestCase
{
    /**
     * @test
     */
    public function 给文章点赞()
    {
        $user = \App\Entity\User::findOrFail(1);
        $post = $user->posts()->first();

        $this->visit(route('post.show',$post->id));

        //未登陆，不能点赞
        $this->click('点赞')
            ->seePageIs('/login');

        //登陆后，点赞
        //点赞人数
        $oldCount = \App\Entity\Vote::where('voteable_id',$post->id)
            ->where('user_id',$user->id)
            ->count();

        $this->actingAs($user);
        $this->visit(route('votePost',$post->id));

        $currentCount = \App\Entity\Vote::where('voteable_id',$post->id)->count();
        $this->assertEquals($oldCount + 1,$currentCount);
    }
}
