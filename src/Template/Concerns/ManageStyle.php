<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait ManageStyle
{
    public function buildCss()
    {
        $tailwind = \Raakkan\PhpTailwind\PhpTailwind::make();
        $tailwind->parse($this->getCssClassesFromBlocksViews());
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
        dd($viewPaths);
        foreach($viewPaths as $viewPath) {
            if (File::exists($viewPath)) {
                $content = File::get($viewPath);
                
                // Remove Blade PHP expressions
                $content = preg_replace('/\{{.*?\}}/s', '', $content);
                $content = preg_replace('/@(?:php|if|else|elseif|endif|unless|endunless|for|endfor|foreach|endforeach|while|endwhile|switch|case|break|default|endswitch).*?$/m', '', $content);
                
                // Extract classes from HTML attributes, including those with Blade syntax
                preg_match_all('/\bclass\s*=\s*(["\'])((?:(?!\1).)*)\1/', $content, $matches);
                
                
                if (!empty($matches[2])) {
                    $blockClasses = collect($matches[2])->flatMap(function ($classString) {
                        // Remove any remaining Blade syntax
                        $classString = preg_replace('/\{{.*?\}}/s', '', $classString);
                        return preg_split('/\s+/', $classString, -1, PREG_SPLIT_NO_EMPTY);
                    })->unique();
                    
                    $cssClasses = $cssClasses->merge($blockClasses);
                }
            }
        }

        return $cssClasses->unique()->implode(' ');
    }
}