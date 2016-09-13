<?php
/**
 * Created by PhpStorm.
 * User: Wang
 * Date: 2016/9/10
 * Time: 13:28
 */

namespace App\Polly3d;


use App\Services\PostShowService;

class PostListNav
{
    protected $filters = [
        PostShowService::ACTIVE => '活跃',
        PostShowService::EXCELLENT => '精华',
        PostShowService::VOTE => '点赞',
        PostShowService::RENCTE => '最近',
        PostShowService::ZERO_COMMENT => '零回复',
    ];

    public function createNav($currentFilter = '')
    {

        $nav = '';
        foreach($this->filters as $key => $filter)
        {
            $liStr = $currentFilter == $key ? '<li class="active">' : '<li>';
            $liStr .= '<a href="'. route('post.index',['filter'=>$key]) . '">'. $filter . '</a>';
            $liStr .= '</li>';
            $nav .= $liStr;
        }
        return $nav;
    }

    public function createCategoryNav($id,$currentFilter = '')
    {
        $nav = '';
        foreach($this->filters as $key => $filter)
        {
            $liStr = $currentFilter == $key ? '<li class="active">' : '<li>';
            $liStr .= '<a href="'. route('category',['id'=>$id,'filter'=>$key]) . '">'. $filter . '</a>';
            $liStr .= '</li>';
            $nav .= $liStr;
        }
        return $nav;
    }
}