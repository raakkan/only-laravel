<?php

namespace Raakkan\OnlyLaravel\Support\Favorites;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class FavoriteModel extends Model
{
    protected $table = 'favorites';
    protected $fillable = ['user_id'];

    public function favoritable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}