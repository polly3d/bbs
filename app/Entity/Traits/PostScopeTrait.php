<?php

namespace App\Entity\Traits;

use Illuminate\Database\Eloquent\Builder;

trait PostScopeTrait
{
    public function scopeExcellent(Builder $query)
    {
        return $query->where('is_excellent','yes');
    }

    public function scopeRecent(Builder $query)
    {
        return $query->orderBy('created_at','desc');
    }

    public function scopeVote(Builder $query)
    {
        return $query->orderBy('vote_count','desc');
    }

    public function scopeRecentUpdated(Builder $query)
    {
        return $query->orderBy('updated_at','desc');
    }

    public function scopeZeroComment(Builder $query)
    {
        return $query->where('comment_count',0);
    }

    public function scopeHot(Builder $query)
    {
        return $query->orderBy('click_count','desc');
    }
}
