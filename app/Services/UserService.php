<?php
/**
 * Created by PhpStorm.
 * User: Wang
 * Date: 2016/9/7
 * Time: 16:13
 */

namespace App\Services;


use App\Entity\Post;
use App\Entity\User;
use App\Entity\Vote;

class UserService
{

    /**
     * 用户的posts
     * @param $userId
     * @param bool $paginate
     * @return Post
     */
    public function getPostsByUserId($userId, $paginate = false)
    {
        $user = User::findOrFail($userId);
        if($paginate)
        {
            $limite = config('blog.user_center_posts_per_page');
            return $user->posts()
                ->orderBy('created_at','desc')
                ->paginate($limite);
        }

        $post = $user->posts()
            ->orderBy('created_at','desc')
            ->take(config('blog.user_center_recent'))
            ->get();

        return $post;
    }

    public function getCommentsByUserId($userId, $paginate = false)
    {
        $user = User::findOrFail($userId);
        if($paginate)
        {
            $limite = config('blog.user_center_comments_per_page');
            return $user->comments()
                ->orderBy('created_at','desc')
                ->paginate($limite);
        }

        $post = $user->comments()
            ->orderBy('created_at','desc')
            ->take(config('blog.user_center_recent'))
            ->get();

        return $post;
    }

    /**
     * 获取某用户所有点赞过的post
     * @param $user_id
     */
    public function getUserVotePost($user_id)
    {
        $user = User::findOrFail($user_id);
        $posts = $user->votePosts()
            ->get();
        return $posts;
    }


}