<?php

namespace Raakkan\OnlyLaravel\Support\Favorites;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Raakkan\OnlyLaravel\Support\Favorites\FavoriteModel as Favorite;

trait Favoritable
{
    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function favoritedUsers(): HasMany
    {
        return $this->hasMany(Favorite::class, 'user_id');
    }

    public function favorite($userId = null)
    {
        $userId = $userId ?? auth()->id();

        return $this->favorites()->updateOrCreate(
            ['user_id' => $userId]
        );
    }

    public function unfavorite($userId = null)
    {
        $userId = $userId ?? auth()->id();

        return $this->favorites()->where('user_id', $userId)->delete();
    }

    public function isFavoritedBy($userId = null)
    {
        $userId = $userId ?? auth()->id();

        return $this->favorites()->where('user_id', $userId)->exists();
    }

    public function favoritesCount()
    {
        return $this->favorites()->count();
    }
}
