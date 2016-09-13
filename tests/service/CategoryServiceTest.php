<?php

use App\Services\CategoryService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryServiceTest extends TestCase
{
    use DatabaseMigrations;
    /** @var  CategoryService */
    protected $service;
    protected function setUp()
    {
        parent::setUp();
        $this->service = $this->app->make(CategoryService::class);

        //生成posts
        $this->artisan('db:seed');
    }

    /**
     * @test
     * 主要用于post的右边栏
     */
    public function 根据category_id获取部分post()
    {
        $category_id = DB::table('categories')->pluck('id');

        $expected = DB::table('posts')
            ->where('category_id',$category_id)
            ->take(config('blog.right_side_catogry_post'))
            ->get();

        $actual = $this->service->getPostById($category_id);

        $this->assertEquals($expected->count(),$actual->count());
    }

    /**
     * @test
     */
    public function 根据category获取所有post并通过filter筛选()
    {
        $limit = config('blog.post_per_page');
        $category_id = DB::table('categories')->pluck('id');

        $expected = DB::table('posts')
            ->where('category_id',$category_id)
            ->orderBy('created_at','desc')
            ->take($limit)
            ->get();

        $filter = \App\Services\PostShowService::RENCTE;

        $actual = $this->service->getPostWithFilterById($category_id,$filter,$limit);

        $this->assertEquals($expected->count(),$actual->count());
        $this->assertEquals($expected->first()->title,$actual->first()->title);
    }
}
