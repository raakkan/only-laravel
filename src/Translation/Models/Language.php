<?php

namespace Raakkan\OnlyLaravel\Translation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Language extends Model
{
    protected $table = 'languages';

    protected $fillable = [
        'name',
        'locale',
        'is_active',
        'is_default',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_default' => 'boolean',
        ];
    }

    public static function getActiveLanguages()
    {
        return Cache::rememberForever('active_languages', function () {
            return self::where('is_active', true)->get();
        });
    }

    public static function getDefaultLanguage()
    {
        return Cache::rememberForever('default_language', function () {
            return self::where('is_default', true)->first();
        });
    }

    public static function getAllLanguages()
    {
        return Cache::rememberForever('all_languages', function () {
            return self::all();
        });
    }

    public static function getAllLocales()
    {
        return Cache::rememberForever('all_locales', function () {
            return self::pluck('locale')->toArray();
        });
    }

    public static function getActiveLocales()
    {
        return Cache::rememberForever('active_locales', function () {
            return self::where('is_active', true)->pluck('locale')->toArray();
        });
    }

    public function getIconAttribute()
    {
        $iconPath = __DIR__.'/../../../resources/svg/'.$this->locale.'.svg';

        if (file_exists($iconPath)) {
            return $this->getIconUrl($this->locale.'.svg');
        }

        return $this->getIconUrl('default.svg');
    }

    private function getIconUrl($filename)
    {
        return asset('vendor/raakkan/only-laravel/svg/'.$filename);
    }
}
