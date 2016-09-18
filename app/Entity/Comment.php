<?php

namespace App\Entity;

use App\Polly3d\MarkdownParser;
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
            $this->attributes['content'] = MarkdownParser::text($value);
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
