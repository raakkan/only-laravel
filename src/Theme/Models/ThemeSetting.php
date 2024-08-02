<?php

namespace Raakkan\OnlyLaravel\Theme\Models;

use Illuminate\Database\Eloquent\Model;

class ThemeSetting extends Model
{
    protected $fillable = ['key', 'value', 'source'];

    protected $casts = [
        'value' => 'json',
    ];

    public static function get(string $source = 'raakkan/laravel-themes-manager', string $key = '*', mixed $default = null): mixed
    {
        $settings = cache()->rememberForever(config('themes-manager.settings.cache_key'), function () use ($source) {
            $settings = [];

            ThemeSetting::where('source', $source)->get()->each(function ($setting) use (&$settings) {
                data_set($settings, $setting->key, $setting->value);
            });

            return $settings;
        });

        if ($key === '*') {
            return $settings;
        }

        return data_get($settings, $key, $default);
    }

    public static function set(string $key, mixed $value, string $source = 'raakkan/laravel-themes-manager'): mixed
    {
        $setting = self::updateOrCreate(
            ['key' => $key, 'source' => $source],
            ['value' => $value]
        );

        cache()->forget(config('themes-manager.settings.cache_key'));

        return $setting->value;
    }

    public static function getCurrentTheme()
    {
        return self::where('key', 'current_theme')->value('value');
    }

    public function getTable(): string
    {
        return config('themes-manager.settings.database_table_name', 'theme_settings');
    }
}
