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

    private static function saveTranslations(string $language, string $group, array $translations, string $prefix = ''): void
    {
        foreach ($translations as $key => $value) {
            if (is_array($value)) {
                self::saveTranslations($language, $group, $value, $prefix.$key.'.');
            } else {
                LanguageLine::updateOrCreate(
                    [
                        'group' => $group,
                        'key' => $prefix.$key,
                    ],
                    [
                        'text' => [$language => $value],
                    ]
                );
            }
        }
    }
}
