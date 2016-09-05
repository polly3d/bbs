<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Post;
use App\Comment;

class ShowTest extends TestCase
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
    public function 显示所有Post()
    {
        factory(Post::class)->create([
            'title'=>'my post',
            'user_id' => $this->user->id,
        ]);

        $this->visit('/')
            ->see('my post')
            ->see($this->user->name);
    }

    /**
     * @test
     */
    public function 显示所有Post并分页()
    {
        factory(Post::class,100)->create([
            'user_id'   =>  $this->user->id,
        ]);

        $this->visit('/')
            ->see('pagination')
            ->see($this->user->name);

    }

    /**
     * @test
     */
    public function 显示某个Post和Post的所有Comment()
    {
        $post = factory(Post::class)->create([
            'title'=>'my post',
            'user_id'=>$this->user->id,
        ]);
        $comment = factory(Comment::class)->create([
            'content'=>'my comment',
            'post_id'=>$post->id,
            'user_id'=>$this->user->id,
        ]);

        $this->visit(route('post.show',$post->id))
            ->see('my post')
            ->see('my comment')
            ->see($this->user->name)
            ->see('comment by')
            ->dontSee('Edit');

        $this->actingAs($this->user)
            ->visit(route('post.show',$post->id))
            ->see('Edit');
    }
}
