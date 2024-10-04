<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait ManageStyle
{
    public function buildCss()
    {
        $tailwind = \Raakkan\PhpTailwind\PhpTailwind::make();
        $tailwind->parse($this->getCssClassesFromBlocks());
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
}