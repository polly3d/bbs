<?php
/**
 * Created by PhpStorm.
 * User: Wang
 * Date: 2016/9/13
 * Time: 15:11
 */

namespace App\Services;


use App\Entity\Category;
use App\Entity\Post;

class CategoryService
{
    public function getPostById($id)
    {
        $posts = Category::findOrFail($id)->posts();
        $posts = $posts->recent()
            ->take(config('blog.right_side_catogry_post'))
            ->get();
        return $posts;
    }

    public function getPostWithFilterById($id,$filter,$limit = 20)
    {
        $post = app()->make(Post::class);
        return $post->getFilterHasPaginate($filter)
            ->where('category_id',$id)
            ->paginate($limit);
    }
}