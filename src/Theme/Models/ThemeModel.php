<?php

namespace Raakkan\OnlyLaravel\Theme\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Raakkan\OnlyLaravel\Theme\ThemeJson;

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
        'update_available',
        'custom_data',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'update_available' => 'boolean',
        'settings' => 'array',
        'custom_data' => 'array',
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

    public function updateTheme(): bool
    {
        $latestVersion = $this->getThemeJson()->getVersion();
        if ($latestVersion > $this->version) {
            return $this->update(['update_available' => false, 'version' => $latestVersion]);
        }

        return false;
    }

    public function getThemeJson(): ?ThemeJson
    {
        return new ThemeJson(app('theme-manager')->getThemePath($this->name).'/theme.json');
    }

    public function hasUpdate(): bool
    {
        return $this->update_available;
    }

    public function getLatestVersion(): string
    {
        return $this->getThemeJson()->getVersion();
    }
}
