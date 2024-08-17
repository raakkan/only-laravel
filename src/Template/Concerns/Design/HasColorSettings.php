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
                ColorPicker::make('backgroundColor')->label('Background Color')->default($this->backgroundColor)->live(debounce: 500),
            ];
        }

        if ($this->backgroundType == BackgroundType::IMAGE) {
            $fields = [
                TextInput::make('backgroundImage')->label('Background Image')->default($this->backgroundImage)->live(debounce: 500),
            ];
        }

        if ($this->backgroundType == BackgroundType::BOTH) {
            $fields = [
                ColorPicker::make('backgroundColor')->label('Background Color')->default($this->backgroundColor)->live(debounce: 500),
                TextInput::make('backgroundImage')->label('Background Image')->default($this->backgroundImage)->live(debounce: 500),
            ];
        }
        
        if ($this->textColorSettings) {
            $fields[] = ColorPicker::make('textColor')->label('Text Color')->default($this->textColor)->live(debounce: 500);
        }
        
        return $fields;
    }

    public function hasColorSettings()
    {
        return $this->backgroundSettings || $this->textColorSettings;
    }
}
