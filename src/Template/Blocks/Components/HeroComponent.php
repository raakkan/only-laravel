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
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasHeightSettings;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasBackgroundSettings;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasTextSettings;

class HeroComponent extends BlockComponent
{
    use HasBackgroundSettings;
    use HasHeightSettings;
    use HasTextSettings;
    protected string $name = 'hero';
    protected $group = 'core';
    protected $source = 'raakkan/only-laravel';
    protected $view = 'only-laravel::template.components.hero';
    protected $title = 'Hero';
    protected $description = 'Hero component';

    public function __construct()
    {
        $this->enableHeightSettingOnly(['heightResponsiveSettings']);
    }

    public function getBlockSettings()
    {
        return [
            TextInput::make('hero.title')
                ->label('Title')
                ->required()
                ->hintAction(
                    Action::make('clear')
                        ->label('Clear')
                        ->icon('heroicon-m-x-circle')
                        ->action(function (Set $set) {
                            $set('onlylaravel.background.color_dark', '');
                        })
                    ),
            TextInput::make('hero.description')
                ->label('Description')
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
            $this->description = $hero['description'] ?? 'Hero description';
        }

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getViewPaths()
    {
        return [
            resource_path('views/vendor/only-laravel/template/components/hero.blade.php'),
            __DIR__ . '/../../../../resources/views/template/components/hero.blade.php',
        ];
    }
}