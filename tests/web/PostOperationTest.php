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

    /**
     * @test
     */
    public function 修改Post()
    {
        $post = $this->user->posts()->first();
        $routeToShowPost = route('post.show',$post->id);
        $this->visit($routeToShowPost)
            ->dontSee('修改');

        $this->actingAs($this->user);
        $this->visit($routeToShowPost)
            ->see('修改');

        $newData = [
            'title' => 'new title',
            'category_id' => 1,
            'content_md' => '#new content',
        ];

        $this->click('修改')
            ->seePageIs(route('post.edit',$post->id));
        $this->visit(route('post.edit',$post->id))
            ->submitForm('提交',$newData)
            ->see('修改成功');

    }

    /**
     * @test
     */
    public function 删除Post()
    {
        $post = $this->user->posts()->first();
        $routeToShowPost = route('post.show',$post->id);
        $this->visit($routeToShowPost)
            ->dontSee('删除');

        $this->actingAs($this->user);
        $this->visit($routeToShowPost)
            ->see('删除');

        $this->click('删除');
        $this->press('确定')
            ->seePageIs(route('post.index'));

        $this->notSeeInDatabase('posts',$post->toArray());
    }

}
