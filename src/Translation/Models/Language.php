<?php

namespace Raakkan\OnlyLaravel\Translation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

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

    public function getIconAttribute()
    {
        $iconPath = __DIR__ . '/../../../resources/svg/' . $this->locale . '.svg';
        
        if (file_exists($iconPath)) {
            return $this->getIconUrl($this->locale . '.svg');
        }

        return $this->getIconUrl('default.svg');
    }

    private function getIconUrl($filename)
    {
        return asset('vendor/raakkan/only-laravel/svg/' . $filename);
    }
}