<?php

use App\Entity\Comment;
use App\Entity\Post;
use App\Services\VoteService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VoteServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $post;
    protected $user;
    /** @var  VoteService */
    protected $voteService;

    protected function setUp()
    {
        parent::setUp();

        //create user
        $this->user = $this->getUser();
        $this->actingAs($this->user);

        //create post
        $this->post = factory(Post::class)->create([
            'user_id' => $this->user->id,
            'category_id' => 1,
        ]);
        //create comment
        factory(Comment::class)->create([
            'user_id'   =>  $this->user->id,
            'post_id'   =>  $this->post->id,
        ]);

        $this->voteService = $this->app->make(VoteService::class);
    }

    /**
     * @test
     */
    public function 给post点赞()
    {
        $vote_count = $this->post->vote_count + 1;
        $actual = $this->voteService->votePost($this->post->id);
        $this->assertEquals($vote_count,$actual->vote_count);
    }

    /**
     * @test
     */
    public function 给comment点赞()
    {
        $comment = $this->post->comments->first();
        $vote_count = $comment->vote_count + 1;
        $actual = $this->voteService->voteComment($comment->id);
        $this->assertEquals($vote_count,$actual->vote_count);
    }
}
