<?php

use App\Services\CommentService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentServiceTest extends TestCase
{
    use DatabaseMigrations;

    /** @var  CommentService */
    protected $commentService;
    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->user = $this->getUser();
        $this->actingAs($this->user);
        $this->commentService = $this->app->make(CommentService::class);
    }

    /**
     * @test
     */
    public function 新建()
    {
        $data = [
            'content_md' => '#hello comment',
            'post_id'   => 1,
        ];

        $actual = $this->commentService->createComment($data);

        $this->assertEquals($data['content_md'],$actual->content_md);

    }

    /**
     * @test
     */
    public function 修改()
    {
        $data = [
            'content_md' => '#hello comment',
            'post_id'   => 1,
        ];

        $comment = $this->commentService->createComment($data);

        $expected = '#baby comment';

        $actual = $this->commentService->updateComment($comment->id,$expected);

        $this->assertEquals($expected,$actual->content_md);
    }

    /**
     * @test
     */
    public function 删除()
    {
        $data = [
            'content_md' => '#hello comment',
            'post_id'   => 1,
        ];

        $comment = $this->commentService->createComment($data);

        $actual = $this->commentService->deleteComment($comment->id);

        $this->assertEquals(true,$actual);

    }
}
