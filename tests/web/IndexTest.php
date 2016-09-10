<?php

use App\Services\PostShowService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IndexTest extends TestCase
{

    /**
     * @test
     */
    public function 首页显示精华贴()
    {
        $service = $this->app->make(PostShowService::class);
        $limit = config('blog.post_per_page');
        $excellentPosts = $service->getFilterHasPaginate(PostShowService::EXCELLENT,$limit);
        $firstPost = $excellentPosts->first();

        $this->visit(route('home'))
            ->see($firstPost->title)
            ->see($firstPost->vote_count);
    }
}
