<?php

use App\Entity\Post;
use App\Services\PostShowService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostShowTest extends TestCase
{
    use DatabaseMigrations;

    /** @var  PostShowService */
    protected $postShowService;

    protected function setUp()
    {
        parent::setUp();
        $this->postShowService = $this->app->make(PostShowService::class);

        //生成posts
        $this->artisan('db:seed');
    }

    /**
     * @test
     */
    public function 主页显示精华贴()
    {
        $limit = config('blog.post_per_page');
        $expected = DB::table('posts')
            ->where('is_excellent','yes')
            ->orderBy('created_at','desc')
            ->take($limit)
            ->get();
        $actual = $this->postShowService->getFilterHasPaginate(PostShowService::EXCELLENT,$limit);
        $this->assertEquals($expected->count(),$actual->count());
    }

    /**
     * @test
     */
    public function 查看活跃()
    {
        $limit = config('blog.post_per_page');
        $expected = DB::table('posts')
            ->orderBy('updated_at','desc')
            ->orderBy('created_at','desc')
            ->take($limit)
            ->get();
        $actual = $this->postShowService->getFilterHasPaginate(PostShowService::ACTIVE,$limit);
        $this->assertEquals($expected->count(),$actual->count());
    }

    /**
     * @test
     */
    public function 查看精华()
    {
        $limit = config('blog.post_per_page');
        $expected = DB::table('posts')
            ->where('is_excellent','yes')
            ->orderBy('created_at','desc')
            ->take($limit)
            ->get();
        $actual = $this->postShowService->getFilterHasPaginate(PostShowService::EXCELLENT,$limit);
        $this->assertEquals($expected->count(),$actual->count());
    }

    /**
     * @test
     */
    public function 查看点赞()
    {
        $limit = config('blog.post_per_page');
        $expected = DB::table('posts')
            ->orderBy('vote_count','desc')
            ->orderBy('updated_at','desc')
            ->orderBy('created_at','desc')
            ->take($limit)
            ->get();
        $actual = $this->postShowService->getFilterHasPaginate(PostShowService::VOTE,$limit);
        $this->assertEquals($expected->count(),$actual->count());
    }

    /**
     * @test
     */
    public function 查看最近()
    {
        $limit = config('blog.post_per_page');
        $expected = DB::table('posts')
            ->orderBy('created_at','desc')
            ->take($limit)
            ->get();
        $actual = $this->postShowService->getFilterHasPaginate(PostShowService::RENCTE,$limit);
        $this->assertEquals($expected->count(),$actual->count());
    }

    /**
     * @test
     */
    public function 查看零回复()
    {
        $limit = config('blog.post_per_page');
        $expected = DB::table('posts')
            ->where('comment_count',0)
            ->orderBy('created_at','desc')
            ->take($limit)
            ->get();
        $actual = $this->postShowService->getFilterHasPaginate(PostShowService::ZERO_COMMENT,$limit);

        $this->assertEquals($expected->count(),$actual->count());
    }


    /**
     * @test
     */
    public function 查看单条post()
    {
        $postId = 1;
        $expected['post'] = DB::table('posts')
            ->where('id',$postId)
            ->first();
        $expected['comments'] = DB::table('comments')
            ->where('post_id',$postId)
            ->get();

        $actual = $this->postShowService->getById($postId);

        $this->assertEquals($expected['post']->title,$actual->title);
        $this->assertEquals($expected['comments']->count(),$actual->comments->count());
    }
}
