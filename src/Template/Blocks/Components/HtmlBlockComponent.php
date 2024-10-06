<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Components;

use Filament\Forms\Components\Textarea;

class HtmlBlockComponent extends BlockComponent
{
    protected string $name = 'html';
    protected $group = 'core';
    protected $source = 'raakkan/only-laravel';
    protected $view = 'only-laravel::template.components.html';
    protected $htmlContent;

    public function __construct()
    {
        $this->backgroundSettings = false;
    }

    public function getBlockSettings()
    {
        return [
            Textarea::make('html.content')
                ->label('HTML Content')
                ->required()
                ->rows(10)
                ->helperText('Warning: Do not insert any potentially dangerous or malicious code.'),

        ];
    }

    public function setBlockSettings($settings)
    {
        if (is_array($settings) && array_key_exists('html', $settings)) {
            $this->htmlContent = $settings['html']['content'] ?? '';
        }

        return $this;
    }

    public function getHtmlContent()
    {
        return $this->htmlContent;
    }
}