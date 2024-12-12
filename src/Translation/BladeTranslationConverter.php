<?php

namespace App;

class BladeTranslationConverter
{
    private string $directory;
    
    public function __construct()
    {
        $this->directory = base_path('themes/mango/views/tools');
    }

    public static function run()
    {
        set_time_limit(300); // Set execution time limit to 5 minutes
        ini_set('memory_limit', '512M'); // Increase memory limit to 512MB
        $converter = new BladeTranslationConverter();
        $duplicates = json_decode(file_get_contents(storage_path('translation-duplicates.json')), true)['items'];
        
        foreach ($duplicates as $duplicate) {
            $occurrences = $duplicate['occurrences'];
            foreach ($occurrences as $occurrence) {
                $oldKey = $occurrence['full_key'];
                $newKey = 'tool.' . $occurrence['key'];
                $converter->convertTranslationKeys($oldKey, $newKey);
            }
        }
    }

    public function convertTranslationKeys($oldKey, $newKey): void
    {
        $files = $this->findBladeFiles($this->directory);
        
        foreach ($files as $file) {
            $content = file_get_contents($file);
            $modifiedContent = $this->replaceTranslationKeys($content, $oldKey, $newKey);
            
            if ($content !== $modifiedContent) {
                $formattedContent = $this->formatCode($modifiedContent);
                file_put_contents($file, $formattedContent);
            }
        }
    }

    private function findBladeFiles(string $directory): array
    {
        $files = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && str_ends_with($file->getFilename(), '.blade.php')) {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }

    private function replaceTranslationKeys(string $content, string $oldKey, string $newKey): string
    {
        // Replace in {{ __('old.key') }} format
        $content = preg_replace(
            '/\{\{\s*__\([\'"]' . preg_quote($oldKey, '/') . '[\'"]\)\s*\}\}/',
            '{{ __(\'' . $newKey . '\') }}',
            $content
        );

        // Replace in @lang('old.key') format
        $content = preg_replace(
            '/@lang\([\'"]' . preg_quote($oldKey, '/') . '[\'"]\)/',
            '@lang(\'' . $newKey . '\')',
            $content
        );

        // Replace in trans('old.key') format
        $content = preg_replace(
            '/trans\([\'"]' . preg_quote($oldKey, '/') . '[\'"]\)/',
            'trans(\'' . $newKey . '\')',
            $content
        );

        return $content;
    }

    private function formatCode(string $content): string
    {
        $lines = explode("\n", $content);
        $formattedLines = [];
        
        foreach ($lines as $line) {
            if (preg_match('/^(\s*)(.*)$/', $line, $matches)) {
                $indentation = $matches[1];
                $code = $matches[2];
                
                if (trim($code) !== '') {
                    $formattedLines[] = $indentation . trim($code);
                } else {
                    $formattedLines[] = '';
                }
            }
        }
        
        return implode("\n", $formattedLines);
    }
} 