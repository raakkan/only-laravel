<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait ManageStyle
{
    public function buildCss()
    {
        $css = $this->getAllBlocksCustomCss() . ' ' . $this->getCssClassesFromBlocksViews() . ' ' . $this->getCustomCss();
        $tailwind = \Raakkan\PhpTailwind\PhpTailwind::make();
        $tailwind->parse($css);
        $tailwind->includePreflight();
        $tailwind->minify();
        $css = $tailwind->toString();

        // Save CSS to file
        $this->saveCssToFile($css);

        return $css;
    }

    protected function saveCssToFile($css)
    {
        $directory = public_path('css/templates');
        $filename = $this->getCssFilename();
        $filePath = $directory . '/' . $filename;

        // Create directory if it doesn't exist
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Save CSS content to file
        File::put($filePath, $css);
    }

    protected function getCssFilename()
    {
        return $this->getSanitizedName() . '.css';
    }

    public function getCssClassesFromBlocksViews()
    {
        $cssClasses = collect();

        $viewPaths = $this->getBlockViewPaths();
        
        foreach ($viewPaths as $viewPath) {
            if (File::exists($viewPath)) {
                $content = File::get($viewPath);
                
                // Extract all class attributes, including those with Blade syntax
                preg_match_all('/\bclass\s*=\s*(["\'])(.*?)\1|\bclass\s*=\s*\{{(.*?)\}}/', $content, $matches, PREG_SET_ORDER);
                
                foreach ($matches as $match) {
                    $classString = $match[2] ?? $match[3] ?? '';
                    
                    // Debug: Print the raw class string
                    // \Log::info("Raw class string: " . $classString);
                    
                    // Process the class string
                    $processedClasses = $this->processClassString($classString);
                    
                    // Debug: Print the processed classes
                    // \Log::info("Processed classes: " . implode(', ', $processedClasses));
                    
                    $cssClasses = $cssClasses->merge($processedClasses);
                }
            }
        }

        // Debug: Print the final collection of classes
        // \Log::info("Final classes: " . $cssClasses->implode(', '));

        return $cssClasses->unique()->implode(' ');
    }

    protected function processClassString($classString)
    {
        // Handle single-line if-else statements and ternary operators
        $classString = preg_replace_callback('/\b(if|elseif|else)\b.*?(\bendif\b|$)|\?.*?:/', function($match) {
            // Remove the if/elseif/else/endif keywords and ternary operators
            $content = preg_replace('/\b(if|elseif|else|endif)\b|\?|:/', ' ', $match[0]);
            // Replace any remaining non-class characters with spaces, preserving colons
            return preg_replace('/[^a-zA-Z0-9\s_:-]/', ' ', $content);
        }, $classString);
        
        // Remove any remaining blade syntax and PHP variables
        $classString = preg_replace('/(\{{|\}})|\$\w+(\-\>\w+)*/', ' ', $classString);
        
        // Split into individual classes, preserving classes with colons and slashes
        $classes = preg_split('/\s+(?=[^:\/]*(:|\/|$))/', $classString, -1, PREG_SPLIT_NO_EMPTY);
        
        // Further process each class to handle cases like 'md w-1/2'
        $processedClasses = [];
        foreach ($classes as $class) {
            if (preg_match('/^(\w+)\s+(.+)$/', $class, $matches)) {
                $processedClasses[] = $matches[1] . ':' . $matches[2];
            } else {
                $processedClasses[] = $class;
            }
        }
        
        return $processedClasses;
    }
}