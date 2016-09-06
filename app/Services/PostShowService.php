<?php
/**
 * Created by PhpStorm.
 * User: Wang
 * Date: 2016/9/5
 * Time: 14:54
 */

namespace App\Services;


use App\Entity\Category;
use App\Entity\Post;
use Illuminate\Database\Eloquent\Collection;

class PostShowService
{
    const EXCELLENT = 'excellents';
    const RENCTE = 'recent';
    const ACTIVE = 'recent';
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
        switch($filter)
        {
            case self::EXCELLENT:
                $post = $this->getExcellents();
                break;
            case self::ACTIVE:
                $post = $this->getActives();
                break;
            case self::VOTE:
                $post = $this->getVotes();
                break;
            case self::ZERO_COMMENT:
                $post = $this->getZeroComent();
                break;
            default:
                $post = $this->getRecents();
                break;
        }

        return $post->paginate($limit);
    }

    /**
     * 精华
     * @return Post
     */
    public function getExcellents()
    {
        return Post::excellent()->recent();
    }

    /**
     * 活跃
     * @return Post
     */
    public function getActives()
    {
        return Post::recentUpdated()->recent();
    }

    /**
     * 最近
     * @return Post
     */
    public function getRecents()
    {
        return Post::recent();
    }

    /**
     * 点赞
     * @return Post
     */
    public function getVotes()
    {
        return Post::vote()->recentUpdated()->recent();
    }

    /**
     * 零回复
     * @return Post
     */
    public function getZeroComent()
    {
        return Post::zeroComment()->recent();
    }

    public function getByCategory($category_id)
    {
        $posts = Category::findOrFail($category_id)
                    ->posts;
        return $posts;
    }


}