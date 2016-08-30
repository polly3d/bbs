<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Post;
use App\Comment;

class ShowTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function 显示所有Post()
    {
        factory(Post::class)->create(['title'=>'my post']);

        $this->visit('/')
            ->see('my post');
    }

    /**
     * @test
     */
    public function 显示某个Post和Post的所有Comment()
    {
        $post = factory(Post::class)->create(['title'=>'my post']);
        $comment = factory(Comment::class)->create(['content'=>'my comment','post_id'=>$post->id]);

        $this->visit(route('post.show',$post->id))
            ->see('my post')
            ->see('my comment');
    }
}
