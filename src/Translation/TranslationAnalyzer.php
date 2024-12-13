<?php

namespace Raakkan\OnlyLaravel\Translation;

use Illuminate\Support\Collection;
use Spatie\TranslationLoader\LanguageLine;

class TranslationAnalyzer
{
    public function findDuplicateTranslations(): Collection
    {
        $allTranslations = LanguageLine::all();
        $duplicates = collect();
        $textMap = [];

        foreach ($allTranslations as $translation) {
            // Skip groups like 'admin' or starting with 'admin_'
            if (preg_match('/^admin(_.*)?$/', $translation->group)) {
                continue;
            }

            foreach ($translation->text as $language => $text) {
                // Skip empty translations
                if (empty($text)) {
                    continue;
                }

                $textKey = $language.'::'.$text;

                if (! isset($textMap[$textKey])) {
                    $textMap[$textKey] = [];
                }

                $textMap[$textKey][] = [
                    'group' => $translation->group,
                    'key' => $translation->key,
                    'language' => $language,
                    'text' => $text,
                ];
            }
        }

        // Filter only duplicates (entries with more than 1 occurrence)
        foreach ($textMap as $textKey => $occurrences) {
            if (count($occurrences) > 1) {
                $duplicates[$textKey] = $occurrences;
            }
        }

        return $duplicates;
    }

    public function getDuplicatesReport(): array
    {
        $duplicates = $this->findDuplicateTranslations();
        $report = [];

        foreach ($duplicates as $textKey => $occurrences) {
            $language = $occurrences[0]['language'];
            $text = $occurrences[0]['text'];

            $report[] = [
                'text' => $text,
                'language' => $language,
                'occurrences' => array_map(function ($occurrence) {
                    return [
                        'group' => $occurrence['group'],
                        'key' => $occurrence['key'],
                        'full_key' => $occurrence['group'].'.'.$occurrence['key'],
                    ];
                }, $occurrences),
                'count' => count($occurrences),
            ];
        }

        return [
            'total_duplicates' => $this->getTotalDuplicates($duplicates),
            'items' => $report,
        ];
    }

    private function getTotalDuplicates(Collection $duplicates): int
    {
        return $duplicates->sum(function ($occurrences) {
            // Subtract 1 from count because we only want to count the extra occurrences
            // e.g., if same text appears 3 times, that means 2 duplicates
            return count($occurrences) - 1;
        });
    }
}
