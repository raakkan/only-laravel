<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Components;

use Filament\Forms\Get;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Blade;
use Filament\Forms\Components\Section;
use Raakkan\OnlyLaravel\Facades\PageManager;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasCustomStyleSettings;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasCustomAttributeSettings;
use csstidy;
class PageDataComponent extends BlockComponent
{
    use HasCustomStyleSettings;
    use HasCustomAttributeSettings;
    
    protected string $name = 'page-data';
    protected string $label = 'Page data';
    protected $group = 'core';
    protected $source = 'raakkan/only-laravel';
    protected $pageDataAttribute = null;
    protected $tags = [
        'div' => 'Div',
        'span' => 'Span',
        'p' => 'P',
    ];
    protected $tag = 'div';

    public function getBlockSettings()
    {
        return [
            Section::make('Page data')
                ->schema([
                    Select::make('page_data.page_model')->label('Page')->options(PageManager::getPageTypeModels())->live(),
                    Select::make('page_data.attribute')->label('Data')->options(function (Get $get) {
                        $pageModel = $get('page_model');

                        if ($pageModel) {
                            return $pageModel::getAccessebleAttributes();
                        }
                    }),
                    Select::make('page_data.tag')->label('Tag')->options($this->tags),
                ])->columns(2)->compact()
        ];
    }

    public function setBlockSettings($settings)
    {
        if (is_array($settings) && array_key_exists('page_data', $settings) && array_key_exists('attribute', $settings['page_data'])) {
            $this->pageDataAttribute = $settings['page_data']['attribute'];
            if (array_key_exists('tag', $settings['page_data'])) {
                $this->tag = $settings['page_data']['tag'];
            }
        }
        return $this;
    }

    public function render()
    {

// $csstidy = new csstidy();

// $csstidy->set_cfg('optimise_shorthands', 2);

// $csstidy->parse(file_get_contents(public_path('css/minimal.css')));
// $csstidy->parse(file_get_contents(public_path('css/normal.css')));

// $optimizedCSS = $csstidy->print->plain();

// file_put_contents(public_path('css/op.css'), $optimizedCSS);

        if ($this->hasPageModel() && $this->pageDataAttribute) {
            $data = $this->getPageModel()->{$this->pageDataAttribute};

            if ($data) {
                return Blade::render(<<<EOT
                <{$this->getTag()} style="{$this->getCustomStyle()} {$this->getBackgroundStyle()}" class="{$this->generateCssClassNames()} {$this->getCustomCss()}" {$this->getCustomAttributes()}>
                    {$data}
                </{$this->getTag()}>
                EOT);
            }
        }
    }

    public function getTag()
    {
        return $this->tag;
    }

    public function generateCssClassNames()
    {
        return 'data-component data-component-' . $this->pageDataAttribute . ' data-component-' . $this->getTag() . '-' . $this->pageDataAttribute  . ' data-component-' . $this->getTag() 
        . ' dark-data-component dark-data-component-' . $this->pageDataAttribute . ' dark-data-component-' . $this->getTag() . '-' . $this->pageDataAttribute . ' dark-data-component-' . $this->getTag() . ' ';
    }
}
