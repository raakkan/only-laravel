<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ColorPicker;
use Raakkan\OnlyLaravel\Template\Enums\BackgroundType;

trait HasColorSettings
{
    protected $backgroundSettings = true;
    protected $backgroundType = BackgroundType::COLOR;
    public $backgroundColor = null;
    public $backgroundImage = null;
    
    protected $textColorSettings = true;
    public $textColor = null;

    public function backgroundSettings($backgroundType = BackgroundType::COLOR, $color = null, $image = null)
    {
        $this->backgroundSettings = true;
        $this->backgroundType = $backgroundType;
        
        if ($backgroundType == BackgroundType::COLOR) {
            $this->backgroundColor = $color;
        }
        
        if ($backgroundType == BackgroundType::IMAGE) {
            $this->backgroundImage = $image;
        }
        return $this;
    }

    public function textColorSettings($color = null)
    {
        $this->textColorSettings = true;
        $this->textColor = $color;
        return $this;
    }

    public function getColorSettingFields()
    {
        $fields = [];
        if ($this->backgroundType == BackgroundType::COLOR) {
            $fields = [
                ColorPicker::make('onlylaravel.color.background.color')->label('Background Color')->default($this->backgroundColor),
            ];
        }

        if ($this->backgroundType == BackgroundType::IMAGE) {
            $fields = [
                TextInput::make('onlylaravel.color.background.image')->label('Background Image')->default($this->backgroundImage),
            ];
        }

        if ($this->backgroundType == BackgroundType::BOTH) {
            $fields = [
                ColorPicker::make('onlylaravel.color.background.color')->label('Background Color')->default($this->backgroundColor),
                TextInput::make('onlylaravel.color.background.image')->label('Background Image')->default($this->backgroundImage),
            ];
        }
        
        if ($this->textColorSettings) {
            $fields[] = ColorPicker::make('onlylaravel.color.text.color')->label('Text Color')->default($this->textColor);
        }
        
        return $fields;
    }

    public function hasColorSettingsEnabled()
    {
        return $this->backgroundSettings || $this->textColorSettings;
    }

    public function setColorSettings($settings)
    {
        if (is_array($settings) && array_key_exists('color', $settings)) {
            $colorSettings = $settings['color'] ?? null;
            if (array_key_exists('background', $colorSettings)) {
                $this->backgroundColor = $colorSettings['background']['color'];
                $this->backgroundImage = $colorSettings['background']['image'] ?? null;
            }
    
            if (array_key_exists('text', $colorSettings)) {
                $this->textColor = $colorSettings['text']['color'];
            }
        }

        return $this;
    }
}
