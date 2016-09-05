<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Post;
use App\Comment;

class CommentTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->user = $this->getUser();
    }

    /**
     * @test
     */
    public function 某个Post下的所有Comment()
    {
        factory(Comment::class,10)->create([
            'user_id'   => $this->user->id,
        ]);

        $postID = 4;
        $expected = DB::table('comments')->where('post_id',$postID)->get()->count();

        $actual = Comment::where('post_id',$postID)->get()->count();

        $this->assertEquals($expected,$actual);
    }

    /**
     * @test
     */
    public function 在某个Post下创建Comment()
    {
        $postId = 4;
        $comment = new Comment();
        $comment->content = 'hello comment';
        $comment->post_id = $postId;
        $comment->user_id = $this->user->id;
        $comment->save();

        $this->seeInDatabase('comments',$comment->toArray());
    }

    /**
     * @test
     */
    public function 修改Comment()
    {
        $postId = 4;
        $comment = new Comment();
        $comment->content = 'hello comment';
        $comment->post_id = $postId;
        $comment->user_id = $this->user->id;
        $comment->save();

        $newComment = Comment::find($comment->id);
        $newComment->content = 'baby comnent';
        $newComment->save();

        $this->seeInDatabase('comments',$newComment->toArray());
    }

    /**
     * @test
     */
    public function 删除Comment()
    {
        $postId = 4;
        $comment = new Comment();
        $comment->content = 'hello comment';
        $comment->post_id = $postId;
        $comment->user_id = $this->user->id;
        $comment->save();
        $this->seeInDatabase('comments',$comment->toArray());

        $comment->delete();
        $this->notSeeInDatabase('comments',$comment->toArray());
    }
}
