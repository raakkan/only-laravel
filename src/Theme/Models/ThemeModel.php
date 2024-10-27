<?php

namespace Raakkan\OnlyLaravel\Theme\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Raakkan\OnlyLaravel\Theme\ThemeJson;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThemeModel extends Model
{
    use SoftDeletes;

    protected $table = 'themes';

    protected $fillable = [
        'name',
        'label',
        'version',
        'description',
        'is_active',
        'settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
    ];

    public function activate(): bool
    {
        static::query()->update(['is_active' => false]);
        $activated = $this->update(['is_active' => true]);
        
        cache()->forget('active_theme');
        
        return $activated;
    }

    public static function activatedTheme(): ?self
    {
        return cache()->rememberForever('active_theme', function () {
            return static::where('is_active', true)->first();
        });
    }

    public function getActiveThemeJson(): ?ThemeJson
    {
        return new ThemeJson(app('theme-manager')->getThemePath($this->name) . '/theme.json');
    }
}
