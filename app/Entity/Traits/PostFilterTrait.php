<?php

namespace App\Entity\Traits;

use App\Entity\Post;
use App\Services\PostShowService;
use Illuminate\Database\Eloquent\Collection;

trait PostFilterTrait
{
    /**
     * 不同索引显示不同数据
     * @param $filter
     * @param int $limit
     * @return Collection
     */
    public function getFilterHasPaginate($filter)
    {
        switch($filter)
        {
            case PostShowService::EXCELLENT:
                $post = $this->getExcellents();
                break;
            case PostShowService::ACTIVE:
                $post = $this->getActives();
                break;
            case PostShowService::VOTE:
                $post = $this->getVotes();
                break;
            case PostShowService::ZERO_COMMENT:
                $post = $this->getZeroComent();
                break;
            default:
                $post = $this->getRecents();
                break;
        }

        return $post;
    }

    /**
     * 精华
     * @return Post
     */
    public function getExcellents()
    {
        return $this->excellent()->recent();
    }

    /**
     * 活跃
     * @return Post
     */
    public function getActives()
    {
        return $this->recentUpdated()->recent();
    }

    /**
     * 最近
     * @return Post
     */
    public function getRecents()
    {
        return $this->recent();
    }

    /**
     * 点赞数
     * @return Post
     */
    public function getVotes()
    {
        return $this->vote()->recentUpdated()->recent();
    }

    /**
     * 零回复
     * @return Post
     */
    public function getZeroComent()
    {
        return $this->zeroComment()->recent();
    }
}
