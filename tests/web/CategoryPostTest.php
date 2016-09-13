<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryPostTest extends TestCase
{
    /**
     * @test
     */
    public function 按分类查看最近()
    {
        $category_id = 1;

        $category = DB::table('posts')
            ->where('category_id',$category_id)
            ->orderBy('created_at','desc')
            ->first();

        $this->visit(route('category',$category_id))
            ->see($category->title);
    }
}
