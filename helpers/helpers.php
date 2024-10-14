<?php

use Raakkan\OnlyLaravel\Setting\Models\Setting;
use Raakkan\OnlyLaravel\Facades\TemplateManager;

if (!function_exists('theme_template')) {
    function theme_template($name)
    {
        return TemplateManager::getTemplate($name);
    }
}

if (!function_exists('setting')) {
    function setting(string|array $key = '*', mixed $default = null): mixed
    {
        if (is_array($key)) {
            $settings = [];

            foreach ($key as $k => $v) {
                data_set($settings, $k, Setting::set($k, $v));
            }

            return $settings;
        }

        return Setting::get($key, $default);
    }
}

if (!function_exists('trans_fallback')) {
    function trans_fallback($key, $fallback, $replace = [], $locale = null)
    {
        if (!app()->bound('translator')) {
            return $fallback;
        }
        $translation = __($key, $replace, $locale);
        
        return $key === $translation ? $fallback : $translation;
    }
}
