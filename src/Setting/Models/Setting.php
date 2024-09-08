<?php

namespace Raakkan\OnlyLaravel\Setting\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    protected $casts = [
        'value' => 'json',
    ];

    public static function get(string $key = '*', mixed $default = null): mixed
    {
        $settings = cache()->rememberForever('onlylaravel.settings', function () {
            $settings = [];

            Setting::all()->each(function ($setting) use (&$settings) {
                data_set($settings, $setting->key, $setting->value);
            });

            return $settings;
        });
        
        if ($key === '*') {
            return $settings;
        }

        return data_get($settings, $key, $default);
    }

    public static function set(string $key, mixed $value): mixed
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        cache()->forget('onlylaravel.settings');

        return $setting->value;
    }

    public function getTable(): string
    {
        return 'settings';
    }
}
