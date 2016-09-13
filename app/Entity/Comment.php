<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = ['content','content_md','post_id','user_id','vote_count'];

    public function setContentMdAttribute($value)
    {
        $this->attributes['content_md'] = $value;

        if($value)
        {
            //todo:这里需要转换
            $this->attributes['content'] = 'md:' . $value;
        }
    }

    public function votes()
    {
        return $this->morphMany(Vote::class,'voteable');
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
