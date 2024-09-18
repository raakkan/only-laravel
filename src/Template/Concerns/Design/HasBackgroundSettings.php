<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Set;
use Illuminate\Support\Arr;
use Filament\Forms\Components\Section;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Actions\Action;
use Raakkan\OnlyLaravel\Template\Enums\BackgroundType;

trait HasBackgroundSettings
{
    protected $backgroundSettings = true;
    protected $backgroundType = BackgroundType::BOTH;

    public function getBackgroundSettingFields()
    {
        $fields = [];
        if ($this->backgroundType == BackgroundType::COLOR) {
            $fields = [
                ColorPicker::make('onlylaravel.background.color')
                    ->label('Background Color')
                    ->default($this->getBackgroundColor())
                    ->rgb()
                    ->hintAction(
                        Action::make('clear')
                            ->label('Clear')
                            ->icon('heroicon-m-x-circle')
                            ->action(function (Set $set) {
                                $set('onlylaravel.background.color', '');
                            })
                    ),
                ColorPicker::make('onlylaravel.background.color_dark')->label('Background Color (Dark)')->default($this->getBackgroundColorDark())
                ->rgb()
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

        if ($this->backgroundType == BackgroundType::IMAGE) {
            $fields = [
                FileUpload::make('onlylaravel.background.image')->label('Background Image')->image()->storeFileNamesIn('attachment_file_names')->directory('templates/backgrounds')->default($this->getBackgroundImage()),
            ];
        }

        if ($this->backgroundType == BackgroundType::BOTH) {
            $fields = [
                ColorPicker::make('onlylaravel.background.color')
                    ->label('Background Color')
                    ->default($this->getBackgroundColor())
                    ->hintAction(
                        Action::make('clear')
                            ->label('Clear')
                            ->icon('heroicon-m-x-circle')
                            ->action(function (Set $set) {
                                $set('onlylaravel.background.color', '');
                            })
                    )->rgba(),
                ColorPicker::make('onlylaravel.background.color_dark')->label('Background Color (Dark)')->default($this->getBackgroundColorDark())->rgba()
                ->hintAction(
                    Action::make('clear')
                        ->label('Clear')
                        ->icon('heroicon-m-x-circle')
                        ->action(function (Set $set) {
                            $set('onlylaravel.background.color_dark', '');
                        })
                ),
                FileUpload::make('onlylaravel.background.image')->label('Background Image')->image()->storeFileNamesIn('attachment_file_names')->directory('templates/backgrounds')->default($this->getBackgroundImage()),
            ];
        }
        
        return $fields;
    }
    
    public function getBackgroundColor()
    {
        return Arr::get($this->settings, 'onlylaravel.background.color', '#ffffff');
    }

    public function getBackgroundImage()
    {
        return Arr::get($this->settings, 'onlylaravel.background.image', '');
    }

    public function getBackgroundColorDark()
    {
        return Arr::get($this->settings, 'onlylaravel.background.color_dark', '#000000');
    }

    public function hasBackgroundSettingsEnabled()
    {
        return $this->backgroundSettings;
    }

    public function backgroundColor($color, $darkColor = null)
    {
        $this->backgroundType = BackgroundType::COLOR;
        $this->backgroundSettings = true;
        Arr::set($this->settings, 'onlylaravel.background.color', $color);
        if ($darkColor) {
            Arr::set($this->settings, 'onlylaravel.background.color_dark', $darkColor);
        }
        return $this;
    }

    public function backgroundImage($image)
    {
        $this->backgroundType = BackgroundType::IMAGE;
        $this->backgroundSettings = true;
        Arr::set($this->settings, 'onlylaravel.background.image', $image);
        return $this;
    }

    public function background($color, $image = '', $darkColor = null)
    {
        $this->backgroundSettings = true;
        $this->backgroundType = BackgroundType::BOTH;
        Arr::set($this->settings, 'onlylaravel.background.color', $color);
        Arr::set($this->settings, 'onlylaravel.background.image', $image);
        if ($darkColor) {
            Arr::set($this->settings, 'onlylaravel.background.color_dark', $darkColor);
        }
        
        return $this;
    }

    public function getBackgroundStyles()
    {
        $styles = [];

        if ($this->backgroundType === BackgroundType::COLOR || $this->backgroundType === BackgroundType::BOTH) {
            $backgroundColor = $this->getBackgroundColor();
            $backgroundColorDark = $this->getBackgroundColorDark();

            if ($backgroundColor) {
                $styles[] = ".bg-{$this->getName()} { background-color: {$backgroundColor} }";
            }

            if ($backgroundColorDark) {
                $styles[] = ".dark\\:bg-{$this->getName()}:where(.dark, .dark *) { background-color: {$backgroundColorDark} }";
            }
        }

        return implode("\n", $styles);
    }

    public function getBackgroundClasses()
    {
        $classes = [];

        if ($this->backgroundType === BackgroundType::COLOR || $this->backgroundType === BackgroundType::BOTH) {
            $classes[] = "bg-{$this->getName()}";
            $classes[] = "dark:bg-{$this->getName()}";
        }

        return implode(' ', $classes);
    }
}
