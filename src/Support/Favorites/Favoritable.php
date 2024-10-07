<?php

namespace Raakkan\OnlyLaravel\Support\Favorites;

use Raakkan\OnlyLaravel\Support\Favorites\FavoriteModel as Favorite;

trait Favoritable
{
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function favorite($userId = null)
    {
        $userId = $userId ?: auth()->id();
        if (!$this->isFavoritedBy($userId)) {
            $this->favorites()->create(['user_id' => $userId]);
        }
    }

    public function unfavorite($userId = null)
    {
        $userId = $userId ?: auth()->id();
        $this->favorites()->where('user_id', $userId)->delete();
    }

    public function isFavoritedBy($userId = null)
    {
        $userId = $userId ?: auth()->id();
        return $this->favorites()->where('user_id', $userId)->exists();
    }

    public function favoriteCount()
    {
        return $this->favorites()->count();
    }
}