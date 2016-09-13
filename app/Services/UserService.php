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

    public function getUserById($id)
    {
        return User::findOrFail($id);
    }

    /**
     * 用户的posts
     * @param User $user
     * @param bool $paginate
     * @return Post
     */
    public function getPostsByUser(User $user, $paginate = false)
    {
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

    /**
     * 用户的回复
     * @param User $user
     * @param bool $paginate
     * @return mixed
     */
    public function getCommentsByUser(User $user, $paginate = false)
    {
        if($paginate)
        {
            $limite = config('blog.user_center_comments_per_page');
            return $user->comments()
                ->orderBy('created_at','desc')
                ->paginate($limite);
        }

        $comments = $user->comments()
            ->orderBy('created_at','desc')
            ->take(config('blog.user_center_recent'))
            ->get();

        return $comments;
    }

    /**
     * 获取某用户所有点赞过的post
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getVotePostByUser(User $user)
    {
        $posts = $user->votePosts()
            ->paginate(config('blog.user_center_posts_per_page'));
        return $posts;
    }


    /**
     * 获得活跃用户
     * @param $limit
     */
    public function getActiveUsers($limit)
    {
        //发贴最多的人 and 回复最多的人
        $usersByCreatePost = \App\Entity\User::withCount('posts')
            ->withCount('comments')
            ->get();

        foreach($usersByCreatePost as &$user)
        {
            $user->active_count = $user->comments_count + $user->posts_count * 4;
        }

        $activeUser = $usersByCreatePost->sortByDesc('active_count')
            ->take($limit);

        return $activeUser;
    }


}