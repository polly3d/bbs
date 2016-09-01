<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Post;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function 获取所有Post()
    {
        /** Arrange */
        factory(Post::class,10)->create();
        $expected = DB::table('posts')->get()->count();

        /** Act */
        $actual = Post::all()->count();

        /** Assert */
        $this->assertEquals($expected,$actual);
    }

    /**
     * @test
     */
    public function 显示某个id的Post()
    {
        factory(Post::class,10)->create();
        $random_id = mt_rand(1,10);
        $expected = DB::table('posts')->where(['id'=>$random_id])->first();

        $actual = Post::find($random_id);

        $this->assertEquals($expected->title,$actual->title);
    }

    /**
     * @test
     */
    public function 获取某个id的Post并且显示该Post的Comment()
    {
        $post = factory(Post::class)->create(['title'=>'my post','content'=>'my content']);
        $comment = factory(\App\Comment::class)->create(['post_id'=>$post->id]);

        $expected = DB::table('posts')->where(['id'=>$post->id])->first();
        $expectedComment = DB::table('comments')->where(['post_id'=>$post->id])->first();

        $actual = Post::findOrFail($post->id);
        $actualComment = $actual->comments->first();

        $this->assertEquals($expected->title,$actual->title);
        $this->assertEquals($expectedComment->content,$actualComment->content);
    }

    /**
     * @test
     */
    public function 修改某个id的Post()
    {
        factory(Post::class,10)->create();
        $random_id = mt_rand(1,10);
        $expected = DB::table('posts')->where(['id'=>$random_id])->first();

        $actual = Post::find($random_id);
        $actual->title = 'change the title';
        $actual->save();

        $this->assertNotEquals($expected->title,$actual->title);
    }

    /**
     * @test
     */
    public function 删除某个id的Post()
    {
        factory(Post::class,10)->create();
        $random_id = mt_rand(1,10);
        $expected = null;

        $deletePost = Post::find($random_id);
        $deletePost->delete();

        $actual = Post::find($random_id);

        $this->assertEquals($expected,$actual);
    }

    /**
     * @test
     */
    public function 新建Post()
    {
        $data = [
            'title' =>  'hello',
            'content'   =>  'hello content',
        ];

        $post = Post::create($data);

        $this->seeInDatabase('posts',$data);
    }
}
