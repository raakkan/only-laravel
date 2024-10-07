<?php

namespace Raakkan\OnlyLaravel\Template;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Raakkan\PhpTailwind\PhpTailwind;

class CssBuilder
{
    protected $views;
    protected $customCss;
    protected $name;
    protected $folderName;

    public function __construct(array $views, string $customCss = '', string $name = '', string $folderName = 'templates')
    {
        $this->views = $views;
        $this->customCss = $customCss;
        $this->name = $name;
        $this->folderName = $folderName;
    }

    public static function make(array $views, string $customCss = '', string $name = '', string $folderName = 'templates'): self
    {
        return new static($views, $customCss, $name, $folderName);
    }

    public function getMinifiedCss(): string
    {
        $css = $this->getCssClassesFromViews() . ' ' . $this->customCss;
        $tailwind = PhpTailwind::make();
        $tailwind->parse($css);
        $tailwind->includePreflight();
        $tailwind->minify();
        return $tailwind->toString();
    }

    protected function getCssClassesFromViews(): string
    {
        $cssClasses = collect();

        foreach ($this->views as $viewPath) {
            
            if (File::exists($viewPath)) {
                
                $content = File::get($viewPath);
                
                preg_match_all('/\bclass\s*=\s*(["\'])(.*?)\1|\bclass\s*=\s*\{{(.*?)\}}/', $content, $matches, PREG_SET_ORDER);
                
                foreach ($matches as $match) {
                    $classString = $match[2] ?? $match[3] ?? '';
                    $processedClasses = $this->processClassString($classString);
                    $cssClasses = $cssClasses->merge($processedClasses);
                }
            }
        }

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

    public function saveCssToFile(): void
    {
        $css = $this->getMinifiedCss();
        $directory = public_path("css/{$this->folderName}");
        $filename = $this->getSanitizedName() . '.css';
        $filePath = $directory . '/' . $filename;

        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        File::put($filePath, $css);
    }

    public function setFileName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setFolderName(string $folderName): self
    {
        $this->folderName = $folderName;
        return $this;
    }

    protected function getSanitizedName(): string
    {
        return Str::slug($this->name);
    }
}