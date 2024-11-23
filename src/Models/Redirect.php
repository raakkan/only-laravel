<?php

namespace Raakkan\OnlyLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    protected $fillable = [
        'from_path',
        'to_path',
        'status_code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'status_code' => 'integer',
    ];

    protected static function booted()
    {
        static::deleted(function () {
            cache()->forget('redirects');
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function getCachedRedirects()
    {
        return cache()->rememberForever('redirects', function () {
            return Redirect::active()->get();
        });
    }
}