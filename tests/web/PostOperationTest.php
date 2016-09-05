<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Post;

class PostOperationTest extends TestCase
{
    use DatabaseMigrations;

    /** @var  \App\User */
    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->user = $this->getUser();
    }

    /**
     * @test
     */
    public function 进入新建Post页面()
    {
        $this->visit('/')
            ->click('Create Post')
            ->seePageIs('/login');
    }

    /**
     * @test
     */
    public function 登陆后进入创建Post页面()
    {
        $this->actingAs($this->user)
            ->visit('/')
            ->click('Create Post')
            ->seePageIs(route('post.create'));

        $this->visit(route('post.create'))
            ->see('Create Post');
    }

    /**
     * @test
     */
    public function 新建Post()
    {
        $data = [
            'title'     =>  'this is title',
            'content'   =>  'blog content',
        ];
        $this->actingAs($this->user)
            ->visit(route('post.create'))
            ->submitForm('create',$data);
        $this->see('create success');
        $this->seeInDatabase('posts',$data);
     }

     /**
      * @test
      */
    public function 进入修改Post页面()
    {
        $post = new Post();
        $post->title = 'title';
        $post->content = 'content post';
        $post->user_id = $this->user->id;
        $post->save();

        $this->actingAs($this->user)
            ->visit(route('post.show',$post->id))
            ->click('Edit')
            ->seePageIs(route('post.edit',$post->id));

        $this->visit(route('post.edit',$post->id))
            ->see($post->title)
            ->see($this->user->id);
     }

    /**
     * @test
     */
    public function 修改Post()
    {
        $post = new Post();
        $post->title = 'title';
        $post->content = 'content post';
        $post->user_id = $this->user->id;
        $post->save();

        $newData = [
            'title'   =>   'new title',
            'content' =>   'new content',
        ];

        $this->notSeeInDatabase('posts',$newData);

        $this->actingAs($this->user)
            ->visit(route('post.edit',$post->id))
            ->type($newData['title'],'title')
            ->type($newData['content'],'content')
            ->press('Update Post');

        $this->seeInDatabase('posts',$newData);
        $this->see('Update Success');
    }

    /**
     * @test
     */
    public function 删除Post()
    {
        $post = new Post();
        $post->title = 'title';
        $post->content = 'content post';
        $post->user_id = $this->user->id;
        $post->save();

        $this->actingAs($this->user)
            ->visit(route('post.show',$post->id))
            ->press('Delete');

        $this->notSeeInDatabase('posts',$post->toArray());

        $this->see('Delete Success');

    }
}
