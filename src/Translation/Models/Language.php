<?php

namespace Raakkan\OnlyLaravel\Translation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use SoftDeletes;

    protected $table = 'languages';

    protected $fillable = [
        'name',
        'locale',
        'rtl',
        'is_active',
        'is_default',
    ];

    protected function casts(): array
    {
        return [
            'rtl' => 'boolean',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
        ];
    }

    public static function getActiveLanguages()
    {
        return self::where('is_active', true)->get();
    }

    public static function getDefaultLanguage()
    {
        return self::where('is_default', true)->first();
    }
}