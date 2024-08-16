<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ColorPicker;
use Raakkan\OnlyLaravel\Template\Enums\BackgroundType;

trait HasColorSettings
{
    protected $backgroundSettings = false;
    protected $backgroundType = BackgroundType::COLOR;
    public $backgroundColor = null;
    public $backgroundImage = null;
    
    protected $textColorSettings = false;
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

    public function getColorSettingFields()
    {
        $fields = [];
        if ($this->backgroundType == BackgroundType::COLOR) {
            $fields = [
                ColorPicker::make('color.background.color')->label('Background Color')->default($this->backgroundColor),
            ];
        }

        if ($this->backgroundType == BackgroundType::IMAGE) {
            $fields = [
                TextInput::make('color.background.image')->label('Background Image')->default($this->backgroundImage),
            ];
        }

        if ($this->backgroundType == BackgroundType::BOTH) {
            $fields = [
                ColorPicker::make('color.background.color')->label('Background Color')->default($this->backgroundColor),
                TextInput::make('color.background.image')->label('Background Image')->default($this->backgroundImage),
            ];
        }
        
        if ($this->textColorSettings) {
            $fields[] = ColorPicker::make('color.text.color')->label('Text Color')->default($this->textColor);
        }
        
        return [
            Section::make('Color Settings')->schema($fields)->compact()
        ];
    }

    public function hasColorSettings()
    {
        return $this->backgroundSettings || $this->textColorSettings;
    }
}
