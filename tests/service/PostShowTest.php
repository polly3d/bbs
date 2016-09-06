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
    public function 根据category查看()
    {
        $category_id = DB::table('categories')->pluck('id');

        $expected = DB::table('posts')
            ->where('category_id',$category_id)
            ->get();
        $actual = $this->postShowService->getByCategory($category_id);

        $this->assertEquals($expected->count(),$actual->count());
    }
}
