<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Components;

use Filament\Forms\Components\Section;
use Filament\Forms\Get;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Blade;
use Raakkan\OnlyLaravel\Facades\PageManager;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasWidthSettings;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasMarginSettings;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasPaddingSettings;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasCustomStyleSettings;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasCustomAttributeSettings;

class PageDataComponent extends BlockComponent
{
    use HasCustomStyleSettings;
    use HasCustomAttributeSettings;
    use HasPaddingSettings;
    use HasMarginSettings;
    use HasWidthSettings;
    
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

    public function __construct()
    {
        $this->enableMarginSettingOnly(['marginResponsiveSettings', 'marginTopResponsiveSettings', 'marginRightResponsiveSettings', 'marginBottomResponsiveSettings', 'marginLeftResponsiveSettings']);
        $this->enablePaddingSettingOnly(['paddingResponsiveSettings', 'paddingTopResponsiveSettings', 'paddingRightResponsiveSettings', 'paddingBottomResponsiveSettings', 'paddingLeftResponsiveSettings']);
        $this->enableWidthSettingOnly(['widthResponsiveSettings', 'minWidthResponsiveSettings', 'maxWidthResponsiveSettings']);
    }

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
        if ($this->hasPageModel() && $this->pageDataAttribute) {
            $data = $this->getPageModel()->{$this->pageDataAttribute};

            if ($data) {
                $paddingStyles = $this->getResponsivePaddingStyles('padding-'. $this->getModel()->id);
                $marginStyles = $this->getResponsiveMarginStyles('margin-'. $this->getModel()->id);
                $widthStyles = $this->getResponsiveWidthStyles('width-'. $this->getModel()->id);
                $maxWidthStyles = $this->getResponsiveMaxWidthStyles('max-width-'. $this->getModel()->id);
                $minWidthStyles = $this->getResponsiveMinWidthStyles('min-width-'. $this->getModel()->id);
                
                return Blade::render(<<<EOT
                <style>
                {$paddingStyles}
                {$marginStyles}
                {$widthStyles}
                {$maxWidthStyles}
                {$minWidthStyles}
                </style>
                <{$this->getTag()} style="{$this->getCustomStyle()}" class="{$this->getCustomCss()} padding-left-{$this->getModel()->id} margin-{$this->getModel()->id} width-{$this->getModel()->id} max-width-{$this->getModel()->id} min-width-{$this->getModel()->id}" {$this->getCustomAttributes()}>
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
}
