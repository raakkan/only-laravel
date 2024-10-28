<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Components;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Raakkan\OnlyLaravel\Admin\Forms\Components\Textarea;

class HtmlBlockComponent extends BlockComponent
{
    protected string $name = 'html';

    protected $group = 'core';

    protected $source = 'raakkan/only-laravel';

    protected $view = 'only-laravel::template.components.html';

    protected $htmlContent;
    protected $customStyleSettings = false;

    protected $customCssSettings = false;

    public function getBlockSettings()
    {
        return [
            Textarea::make('html.content')
                ->label('HTML Content')
                ->required()
                ->default($this->getHtmlContent())
                ->rows(10)
                ->helperText('Warning: Do not insert any potentially dangerous or malicious code.'),

        ];
    }

    public function setBlockSettings($settings)
    {
        if (is_array($settings) && array_key_exists('html', $settings)) {
            $this->htmlContent = $settings['html']['content'] ?? '';
            if ($this->htmlContent) {
                $this->extractCssClasses($this->htmlContent);
            }
        }

        return $this;
    }

    public function getHtmlContent()
    {
        return $this->htmlContent;
    }

    public function html($content)
    {
        $this->htmlContent = $content;
        $this->extractCssClasses($content);

        return $this;
    }

    protected function extractCssClasses($html)
    {
        preg_match_all('/class=["\']([^"\']*)["\']/', $html, $matches);
        $classes = [];
        foreach ($matches[1] as $classString) {
            $classes = array_merge($classes, explode(' ', $classString));
        }
        $extractedClasses = array_unique(array_filter($classes));

        $existingClasses = explode(' ', $this->otherCssClasses);
        $allClasses = array_unique(array_merge($existingClasses, $extractedClasses));
        $this->otherCssClasses = implode(' ', $allClasses);
    }

    public function render()
    {
        return new HtmlString($this->getHtmlContent());
    }
}
