<?php

use App\Services\PostShowService;
use App\Services\UserService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostListTest extends TestCase
{
    /**
     * @test
     */
    public function 默认查看活跃()
    {
        $laterActivePost = DB::table('posts')
             ->orderBy('updated_at','desc')
             ->orderBy('created_at','desc')
             ->first();
        $this->visit(route('post.index'))
            ->see($laterActivePost->title);
    }

    /**
     * @test
     * 因为精华、点赞、最近、零回复都基本类似的，所以就只测试一个就好了。
     * 如果出错，那也是排序的定义出错了
     */
    public function 查看精华()
    {
        $laterActivePost = DB::table('posts')
            ->where('is_excellent','yes')
            ->orderBy('created_at','desc')
            ->first();
        $this->visit(route('post.index'))
            ->click('精华')
            ->see($laterActivePost->title);


        $zeroComment = DB::table('posts')
            ->where('comment_count',0)
            ->orderBy('created_at','desc')
            ->first();
        $this->visit(route('post.index'))
            ->click('零回复')
            ->see($zeroComment->title);
    }

    /**
     * @test
     */
    public function 活跃用户()
    {
        $limit = config('blog.active_user_number');

        $expected = $this->app->make(UserService::class)->getActiveUsers($limit);

        $randomUser = $expected->random();

        $this->visit(route('post.index'))
            ->see($randomUser->name);
    }

    /**
     * @test
     */
    public function 热门主题()
    {
        $limit = config('blog.hot_post');

        /** @var PostShowService $service */
        $service = $this->app->make(PostShowService::class);

        $expected = $service->getHotPosts($limit);

        $randomPost = $expected->random();

        $this->visit(route('post.index'))
            ->see($randomPost->title);
    }
}
