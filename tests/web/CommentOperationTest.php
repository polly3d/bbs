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
    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->user = factory(\App\User::class)->create();

        $this->post = new Post();
        $this->post->title = 'title';
        $this->post->content = 'content';
        $this->post->user_id = $this->user->id;
        $this->post->save();
    }


    /**
     * @test
     */
    public function 未登陆新建Comment()
    {
        $comment = 'I have a comment';
        $this->visit(route('post.show',$this->post->id))
            ->type($comment,'content')
            ->press('Comment');

        $this->seePageIs('/login');
        $this->notSeeInDatabase('comments',['content'=>$comment,'post_id'=>$this->post->id]);
    }

    /**
     * @test
     */
    public function 登陆后新建Comment()
    {
        $this->actingAs($this->user);

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
        $comment->user_id = $this->user->id;
        $comment->save();

        //未登陆时，看不到删除按钮
        $this->visit(route('post.show',$this->post->id))
            ->dontSee('Delete Comment');

        //登陆后，可以看到删除按钮，并可以执行删除操作
        $this->actingAs($this->user);
        $this->visit(route('post.show',$this->post->id))
            ->see('Delete Comment')
            ->press('Delete Comment');

        $this->see('Delete Success');
        $this->notSeeInDatabase('comments',$comment->toArray());
    }
}
