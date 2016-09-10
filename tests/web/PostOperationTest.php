<?php

use App\Services\PostOperationService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostOperationTest extends TestCase
{
    protected $service;
    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->user = \App\Entity\User::findOrFail(1);
    }

    /**
     * @test
     */
    public function 新建Post()
    {
        $data = [
            'category_id'   =>  1,
            'title' => 'title',
            'content_md'    =>  '#hello world',
        ];

        $routeToCreate = route('post.create');
        $this->visit(route('post.index'))
            ->click('新建帖子')
            ->seePageIs('login');

        $this->actingAs($this->user);
        $this->service = $this->app->make(PostOperationService::class);
        $this->visit($routeToCreate)
            ->submitForm('新建',$data)
            ->see('创建成功');
        $this->seeInDatabase('posts',$data);
    }

    public function 修改Post()
    {

    }

    public function 删除Post()
    {

    }

}
