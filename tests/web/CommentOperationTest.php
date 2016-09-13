<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentOperationTest extends TestCase
{
    protected $user;

    protected $post;

    protected $route;

    protected function setUp()
    {
        parent::setUp();
        $this->user = \App\Entity\User::findOrFail(1);
        $this->post = $this->user->posts()->first();
        $this->route = route('post.show', $this->post->id);
    }

    /**
     * @test
     */
    public function 回复()
    {
        $data = [
            'content_md' => '# new content',
        ];
        $this->visit($this->route)
            ->submitForm('回复',$data)
            ->seePageIs('/login');

        $this->actingAs($this->user);
        $this->visit($this->route)
            ->submitForm('回复',$data)
            ->seePageIs($this->route);

        $this->seeInDatabase('comments',$data);
    }

    public function 回复点赞()
    {

    }
}
