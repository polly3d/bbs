<?php
/**
 * Created by PhpStorm.
 * User: Wang
 * Date: 2016/9/5
 * Time: 14:54
 */

namespace App\Services;


use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Illuminate\Database\Eloquent\Collection;

class PostShowService
{
    const EXCELLENT = 'excellents';
    const RENCTE = 'recent';
    const ACTIVE = 'active';
    const VOTE = 'vote';
    const ZERO_COMMENT = 'zeorComment';

    /**
     * 不同索引显示不同数据
     * @param $filter
     * @param int $limit
     * @return Collection
     */
    public function getFilterHasPaginate($filter,$limit = 20)
    {
        $post = app()->make(Post::class);
        return $post->getFilterHasPaginate($filter)
            ->paginate($limit);
    }

    /**
     * 精华
     * @return Post
     */
    public function getExcellents(Post $post)
    {
        return $post->getExcellents();
    }

    /**
     * 活跃
     * @return Post
     */
    public function getActives(Post $post)
    {
        return $post->getActives();
    }

    /**
     * 最近
     * @return Post
     */
    public function getRecents(Post $post)
    {
        return $post->getRecents();
    }

    /**
     * 点赞
     * @return Post
     */
    public function getVotes(Post $post)
    {
        return $post->getVotes();
    }

    /**
     * 零回复
     * @return Post
     */
    public function getZeroComent(Post $post)
    {
        return $post->getZeroComment();
    }

    /**
     * 仅仅只返回Post信息
     * @param $postId
     * @return Post
     */
    public function getByIdOnlyPost($postId)
    {
        return Post::findOrFail($postId);
    }


    /**
     * 通过id获取post内容和post的所有回复
     * @param $postId
     */
    public function getById($postId)
    {
        $data = [];

        //post、user comments and vote
        $post = Post::with('comments','user','votes','votes.user')
            ->with(['user.posts' => function($query){
                $query->orderBy('created_at','desc')
                    ->take(config('blog.right_side_user_post'));
            }])
            ->findOrFail($postId);
        return $post;
    }

    /**
     * 热门主题
     * 点击率高的主题
     * @param $limit
     * @return Post
     */
    public function getHotPosts($limit)
    {
        $hotPosts = Post::hot()
            ->recent()
            ->take($limit)
            ->get();
        return $hotPosts;
    }


}