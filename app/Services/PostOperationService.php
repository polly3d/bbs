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
     * 帖子设为精华
     * @param $id
     * @return
     */
    public function toExcellent($id)
    {
        $post = Post::findOrFail($id);
        if($post->is_excellent == 'no')
        {
            $post->is_excellent = 'yes';
        }
        else
        {
            $post->is_excellent = 'no';
        }
        $post->save();
        return $post;
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
    public function updatePost($id, $data)
    {
        $post = $this->checkPermission($id);
        if($post)
        {
            foreach($data as $key=>$item)
            {
                $post->$key = $item;
            }
            $post->save();
        }
        return $post;
    }

    /**
     * 删除post
     * 同时，需要删除帖子对应的comments和votes
     * @param $id
     * @return bool
     */
    public function deletePost($id)
    {
        $post = $this->checkPermission($id);
        if($post)
        {
            $post->comments()->delete();
            $post->votes()->delete();
            return $post->delete();
        }
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