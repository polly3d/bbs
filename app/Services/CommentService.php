<?php
/**
 * Created by PhpStorm.
 * User: Wang
 * Date: 2016/9/6
 * Time: 11:36
 */

namespace App\Services;


use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    /**
     * CommentService constructor.
     */
    public function __construct()
    {
        if(!Auth::check())
        {
            throw new AuthenticationException('登陆后才能够操作comment');
        }
    }


    /**
     * 保存回复
     * @param $data
     * @return Comment
     */
    public function createComment($data)
    {
        $data['user_id'] = Auth::id();
        $comment = Comment::create($data);
        return $comment;
    }

    /**
     * 更新回复,todo:理论上回复是不能被更新的，有待讨论
     * @param $id
     * @param $content
     * @return Comment
     */
    public function updateComment($id, $content)
    {
        $comment = Comment::findOrFail($id);
        $comment->content_md = $content;
        $comment->save();
        return $comment;
    }

    /**
     * 删除回复
     * @param $id
     * @return bool
     */
    public function deleteComment($id)
    {
        $result = false;
        $comment = Comment::findOrFail($id);
        if($comment->user_id == Auth::id())
        {
            $result = $comment->delete();
        }
        return $result;
    }
}