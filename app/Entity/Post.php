<?php

namespace App\Entity;

use App\Entity\Present\PostPresent;
use App\Entity\Traits\PostFilterTrait;
use App\Entity\Traits\PostScopeTrait;
use App\Polly3d\MarkdownParser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    use PostscopeTrait;
    use PostPresent;
    use PostFilterTrait;


    protected $fillable = [
        'title',
        'content',
        'content_md',
        'user_id',
        'category_id',
    ];

    public function setContentMdAttribute($value)
    {
        $this->attributes['content_md'] = $value;

        if($value)
        {
            $this->attributes['content'] = MarkdownParser::text($value);
        }
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function votes()
    {
        return $this->morphMany(Vote::class,'voteable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
