<?php

use App\Entity\Post;
use App\Entity\User;
use App\Services\PostOperationService;
use App\Services\PostShowService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostOperationTest extends TestCase
{
    use DatabaseMigrations;

    /** @var  PostOperationService */
    protected $postOperationService;
    /** @var  PostShowService */
    protected $postShowService;
    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed');
        $this->user = User::findOrFail(1);
        $this->actingAs($this->user);

        $this->postShowService = $this->app->make(PostShowService::class);
        $this->postOperationService = $this->app->make(PostOperationService::class);
    }

    /**
     * @test
     */
    public function 新建()
    {
        $post = $this->createPost();
        $this->seeInDatabase('posts',$post->toArray());
    }

    /**
     * @test
     */
    public function 编辑()
    {
        $post = $this->createPost();
        $data = ['content_md'=>'#new content'];

        //登陆后，方可编辑
        $newPost = $this->postOperationService->updatePost($post->id,$data);
        $this->assertEquals($data['content_md'],$newPost->content_md);

        //而且只能编辑自己的帖子
        $newUser = User::findOrFail(2);
        $this->actingAs($newUser);
        $data = '#new user content';
        $newPost = $this->postOperationService->updatePost($post->id,$data);
        $this->assertFalse($newPost);

    }

    /**
     * @test
     */
    public function 删除()
    {
        //登陆后，方可删除
        $post = $this->createPost();
        $acual = $this->postOperationService->deletePost($post->id);
        $this->assertTrue($acual);

        //而且只能删除自己的帖子
        $post = $this->createPost();
        $newUser = User::findOrFail(2);
        $this->actingAs($newUser);
        $acual = $this->postOperationService->deletePost($post->id);
        $this->assertFalse($acual);

    }

    /**
     * @return array
     */
    private function createPost()
    {
        $data = [
            'title' => 'title',
            'category_id' => 1,
            'content_md' => '#hello content',
        ];
        //已经登陆才能新建成功
        $post = $this->postOperationService->createPost($data);
        return $post;
    }
}
