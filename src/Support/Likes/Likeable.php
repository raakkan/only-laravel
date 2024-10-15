<?php

namespace Raakkan\OnlyLaravel\Support\Likes;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Raakkan\OnlyLaravel\Support\Likes\LikeModel;

trait Likeable
{
    public function likes(): MorphMany
    {
        return $this->morphMany(LikeModel::class, 'likeable');
    }

    public function likedUsers(): HasMany
    {
        return $this->hasMany(LikeModel::class, 'user_id');
    }

    public function like($userId = null)
    {
        $userId = $userId ?? auth()->id();
        
        if ($this->id === $userId) {
            return;
        }

        $this->likes()->updateOrCreate(
            ['user_id' => $userId],
            ['is_like' => true]
        );
    }

    public function unlike($userId = null)
    {
        $userId = $userId ?? auth()->id();
        
        $this->likes()->updateOrCreate(
            ['user_id' => $userId],
            ['is_like' => false]
        );
    }

    public function isLikedBy($userId)
    {
        return $this->likes()
            ->where('user_id', $userId)
            ->where('is_like', true)
            ->exists();
    }

    public function likesCount()
    {
        return $this->likes()->where('is_like', true)->count();
    }

    // public function getLikesCountAttribute()
    // {
    //     return $this->likes()->where('is_like', true)->count();
    // }

    // public function getUnlikesCountAttribute()
    // {
    //     return $this->likes()->where('is_like', false)->count();
    // }
}
