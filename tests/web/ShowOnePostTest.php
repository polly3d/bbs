<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowOnePostTest extends TestCase
{
    /**
     * @test
     */
    public function 显示单个Post()
    {
        $postId = 1;
        $post = \App\Entity\Post::with('user')->findOrfail($postId);

        $this->visit(route('post.show',$postId))
            ->see($post->title)
            ->see($post->content)
            ->see($post->user->name);

        $this->visit(route('post.show',$postId))
            ->see($post->user->name.' 的其他话题')
            ->see($post->user->email)
            ->see('作者：'.$post->user->name);

        //user's posts
        $userAllPosts = $post->user
            ->posts()
            ->orderBy('created_at','desc')
            ->take(config('blog.right_side_user_post'))
            ->get();
        $randomPost = $userAllPosts->random();
        $this->visit(route('post.show',$postId))
            ->see($randomPost->title);

        $categoryPosts = \App\Entity\Post::where('category_id',$post->category_id)
            ->orderBy('created_at','desc')
            ->take(config('blog.right_side_catogry_post'))
            ->get();
        $randomCategoryPost = $categoryPosts->random();
        $this->see($randomCategoryPost->title);
    }
}
