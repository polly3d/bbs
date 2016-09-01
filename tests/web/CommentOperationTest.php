<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Post;
use App\Comment;

class CommentOperationTest extends TestCase
{
    use DatabaseMigrations;

    protected $post;

    protected function setUp()
    {
        parent::setUp();

        $this->post = new Post();
        $this->post->title = 'title';
        $this->post->content = 'content';
        $this->post->save();
    }


    /**
     * @test
     */
    public function 新建Comment()
    {
        $comment = 'I have a comment';
        $this->visit(route('post.show',$this->post->id))
            ->type($comment,'content')
            ->press('Comment');

        $this->see('Comment Success');
        $this->seeInDatabase('comments',['content'=>$comment,'post_id'=>$this->post->id]);
    }

    public function 修改Comment()
    {
        //偷懒，暂时设定为评论不能修改好了
    }

    /**
     * @test
     */
    public function 删除Comment()
    {
        $comment = new Comment();
        $comment->content = 'I have a dream!';
        $comment->post_id = $this->post->id;
        $comment->save();

        $this->visit(route('post.show',$this->post->id))
            ->press('Delete Comment');
        $this->see('Delete Success');
        $this->notSeeInDatabase('comments',$comment->toArray());
    }
}