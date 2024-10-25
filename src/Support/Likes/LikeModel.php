<?php

namespace Raakkan\OnlyLaravel\Support\Likes;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class LikeModel extends Model
{
    protected $table = 'likes';

    protected $fillable = ['user_id', 'is_like'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }
}
