<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Concerns;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ColorPicker;
use Raakkan\OnlyLaravel\Theme\Enums\BackgroundType;

trait HasBackgroundSettings
{
    protected $backgroundSettings = false;
    protected $backgroundType = BackgroundType::COLOR;
    protected $background = [
        'color' => null,
        'image' => null
    ];

    public function backgroundSettings($backgroundType = BackgroundType::COLOR, $color = null, $image = null)
    {
        $this->backgroundSettings = true;
        $this->backgroundType = $backgroundType;
        $this->background = [
            'color' => $color,
            'image' => $image
        ];
        return $this;
    }

    public function getBackgroundSettings()
    {
        $fields = [];
        if ($this->backgroundType == BackgroundType::COLOR) {
            $fields = [
                ColorPicker::make('background.color')->default($this->background['color']),
            ];
        }

        if ($this->backgroundType == BackgroundType::IMAGE) {
            $fields = [
                TextInput::make('background.image')->default($this->background['image']),
            ];
        }

        if ($this->backgroundType == BackgroundType::BOTH) {
            $fields = [
                ColorPicker::make('background.color')->default($this->background['color']),
                TextInput::make('background.image')->default($this->background['image']),
            ];
        }
        
        return [
            Section::make('Background')->schema($fields)->compact()
        ];
    }

    public function backgroundSettingsEnabled()
    {
        return $this->backgroundSettings;
    }
}