<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Concerns;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ColorPicker;
use Raakkan\OnlyLaravel\Theme\Enums\BackgroundType;

trait HasColorSettings
{
    protected $backgroundSettings = false;
    protected $backgroundType = BackgroundType::COLOR;
    protected $background = [
        'color' => null,
        'image' => null
    ];
    
    protected $textColorSettings = false;
    protected $textColor = null;

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
                ColorPicker::make('background.color')->label('Background Color')->default($this->background['color']),
            ];
        }

        if ($this->backgroundType == BackgroundType::IMAGE) {
            $fields = [
                TextInput::make('background.image')->label('Background Image')->default($this->background['image']),
            ];
        }

        if ($this->backgroundType == BackgroundType::BOTH) {
            $fields = [
                ColorPicker::make('background.color')->label('Background Color')->default($this->background['color']),
                TextInput::make('background.image')->label('Background Image')->default($this->background['image']),
            ];
        }
        
        if ($this->textColorSettings) {
            $fields[] = ColorPicker::make('text_color')->label('Text Color')->default($this->textColor);
        }
        
        return [
            Section::make('Color Settings')->schema($fields)->compact()
        ];
    }

    public function backgroundSettingsEnabled()
    {
        return $this->backgroundSettings;
    }

    public function setBackground($background)
    {
        $this->background = $background;
        return $this;
    }

    public function getBackgroundColor()
    {
        return $this->background['color'];
    }

    public function getBackgroundImage()
    {
        return $this->background['image'];
    }
    
    public function textColorSettings($color = null)
    {
        $this->textColorSettings = true;
        $this->textColor = $color;
        return $this;
    }
    
    public function textColorSettingsEnabled()
    {
        return $this->textColorSettings;
    }
    
    public function setTextColor($color)
    {
        $this->textColor = $color;
        return $this;
    }
    
    public function getTextColor()
    {
        return $this->textColor;
    }
}
