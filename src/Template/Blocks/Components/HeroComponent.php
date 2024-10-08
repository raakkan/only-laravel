<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Components;

use Filament\Forms\Set;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Actions\Action;
use Raakkan\OnlyLaravel\Support\Concerns\HasTitle;

class HeroComponent extends BlockComponent
{
    use HasTitle {
        getTitle as parentGetTitle;
        getSubtitle as parentGetSubtitle;
    }
    protected string $name = 'hero';
    protected string $label = 'Hero';
    protected $group = 'core';
    protected $source = 'raakkan/only-laravel';
    protected $view = 'only-laravel::template.components.hero';

    public function __construct()
    {
        $this->enableCustomStyleSettingOnly(['customStyleSettings', 'customCssSettings']);
    }

    public function getBlockSettings()
    {
        return [
            TextInput::make('hero.title')
                ->label('Title')
                ->required()
                ->default($this->getTitle())
                ->hintAction(
                    Action::make('clear')
                        ->label('Clear')
                        ->icon('heroicon-m-x-circle')
                        ->action(function (Set $set) {
                            $set('onlylaravel.background.color_dark', '');
                        })
                    ),
            TextInput::make('hero.subtitle')
                ->label('Subtitle')
                ->default($this->getSubtitle())
                ->hintAction(
                    Action::make('clear')
                        ->label('Clear')
                        ->icon('heroicon-m-x-circle')
                        ->action(function (Set $set) {
                            $set('onlylaravel.background.color_dark', '');
                        })
                ),
        ];
    }

    public function setBlockSettings($settings)
    {
        if (is_array($settings) && array_key_exists('hero', $settings)) {
            $hero = $settings['hero'];

            $this->title = $hero['title'] ?? 'Hero';
            $this->subtitle = $hero['subtitle'] ?? 'Hero subtitle';
        }

        return $this;
    }

    public function getTitle()
    {
        return $this->title ?? 'Hero Title';
    }

    public function getSubtitle()
    {
        return $this->subtitle ?? 'Hero Subtitle';
    }

    public function getViewPaths()
    {
        return [
            resource_path('views/vendor/only-laravel/template/components/hero.blade.php'),
            __DIR__ . '/../../../../resources/views/template/components/hero.blade.php',
        ];
    }
}