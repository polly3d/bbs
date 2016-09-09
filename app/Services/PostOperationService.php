<?php
/**
 * Created by PhpStorm.
 * User: Wang
 * Date: 2016/9/7
 * Time: 14:37
 */

namespace App\Services;



use App\Entity\Post;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

class PostOperationService
{
    /**
     * PostOperationService constructor.
     */
    public function __construct()
    {
        if(!Auth::check())
        {
            throw new AuthorizationException('登陆后才能够操作');
        }
    }


    /**
     * 创建post
     * @param array $data
     * @return Post|bool
     */
    public function createPost($data)
    {
        $data['user_id'] = Auth::id();
        $post = Post::create($data);
        return $post;
    }

    /**
     * 更新post
     * @param $id
     * @param $contentMd
     * @return Post|bool
     */
    public function updatePost($id, $contentMd)
    {
        $post = $this->checkPermission($id);
        if($post)
        {
            $post->content_md = $contentMd;
            $post->save();
        }
        return $post;
    }

    /**
     * 删除post
     * @param $id
     * @return bool
     */
    public function deletePost($id)
    {
        $post = $this->checkPermission($id);
        if($post)
            return $post->delete();
        return $post;
    }

    private function checkPermission($id)
    {
        $post = Post::findOrFail($id);
        if($post->user_id == Auth::id())
        {
            return $post;
        }
        return false;
    }
}