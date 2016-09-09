<?php
/**
 * Created by PhpStorm.
 * User: Wang
 * Date: 2016/9/7
 * Time: 17:11
 */

namespace App\Services;


use App\Entity\Comment;
use App\Entity\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class VoteService
{

    /**
     * @param $id
     * @return Vote
     */
    public function votePost($id)
    {
        $post = Post::findOrFail($id);
        return $this->vote($post);
    }

    /**
     * @param $id
     * @return bool
     */
    public function voteComment($id)
    {
        $comment = Comment::findOrFail($id);
        return $this->vote($comment);
    }

    protected function vote(Model $model)
    {
        $user_id = Auth::id();
        $hasAlreadyVote = $model->votes()
            ->where('user_id',$user_id)
            ->count();
        if($hasAlreadyVote)
        {
            //已经点赞，则取消点赞
            $model->votes()
                ->where('user_id',$user_id)
                ->delete();
            $model->decrement('vote_count',1);
        }
        else
        {
            //点赞
            $model->votes()
                ->create([
                    'user_id' => $user_id,
                ]);
            $model->increment('vote_count',1);
        }
        return $model;
    }
}