<?php

namespace Raakkan\OnlyLaravel\Translation;

use Illuminate\Support\Facades\File;
use Spatie\TranslationLoader\LanguageLine;

class TranslationLoader
{
    public static function loadAndSave(string $langPath = 'lang'): void
    {
        if (! File::exists(base_path($langPath))) {
            return;
        }

        $languages = File::directories(base_path($langPath));

        foreach ($languages as $languageDir) {
            $language = basename($languageDir);
            $files = File::files($languageDir);

            foreach ($files as $file) {
                $group = pathinfo($file, PATHINFO_FILENAME);
                $translations = include $file;

                self::saveTranslations($language, $group, $translations);
            }
        }
    }

    private static function saveTranslations(string $language, string $group, array|string $translations, string $prefix = ''): void
    {
        // Handle non-array values (leaf nodes)
        if (!is_array($translations)) {
            LanguageLine::updateOrCreate(
                [
                    'group' => $group,
                    'key' => rtrim($prefix, '.'),
                ],
                [
                    'text' => [$language => $translations],
                ]
            );
            return;
        }

        // Handle array values (nested nodes)
        foreach ($translations as $key => $value) {
            $newPrefix = $prefix . $key . '.';
            self::saveTranslations($language, $group, $value, $newPrefix);
        }
    }
}
