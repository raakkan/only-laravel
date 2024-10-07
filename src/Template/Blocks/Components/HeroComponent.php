<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Components;

use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Actions\Action;
use Raakkan\OnlyLaravel\Support\Concerns\HasTitle;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasTextSettings;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasHeightSettings;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasBackgroundSettings;

class HeroComponent extends BlockComponent
{
    use HasBackgroundSettings;
    use HasHeightSettings;
    use HasTextSettings;
    use HasTitle {
        getTitle as parentGetTitle;
        getSubtitle as parentGetSubtitle;
    }
    protected string $name = 'hero';
    protected $group = 'core';
    protected $source = 'raakkan/only-laravel';
    protected $view = 'only-laravel::template.components.hero';

    public function __construct()
    {
        $this->enableHeightSettingOnly(['heightResponsiveSettings']);
        $this->responsiveHeight([
            'height' => 100,
            'small' => 300,
            'medium' => 400,
            'large' => 500,
            'extra_large' => 600,
            '2_extra_large' => 700
        ], [
            'unit' => 'pixels',
            'small' => 'pixels',
            'medium' => 'pixels',
            'large' => 'pixels',
            'extra_large' => 'pixels',
            '2_extra_large' => 'pixels'
        ]   );
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

    public function getDescription()
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