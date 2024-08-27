<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ColorPicker;
use Raakkan\OnlyLaravel\Template\Enums\BackgroundType;

trait HasColorSettings
{
    protected $backgroundSettings = true;
    protected $backgroundType = BackgroundType::BOTH;
    public $backgroundColor = null;
    public $backgroundImage = null;

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
                ColorPicker::make('onlylaravel.background.color')->label('Background Color')->default($this->backgroundColor),
            ];
        }

        if ($this->backgroundType == BackgroundType::IMAGE) {
            $fields = [
                FileUpload::make('onlylaravel.background.image')->label('Background Image')->image()->storeFileNamesIn('attachment_file_names')->directory('templates/backgrounds'),
            ];
        }

        if ($this->backgroundType == BackgroundType::BOTH) {
            $fields = [
                ColorPicker::make('onlylaravel.background.color')->label('Background Color')->default($this->backgroundColor),
                FileUpload::make('onlylaravel.background.image')->label('Background Image')->image()->storeFileNamesIn('attachment_file_names')->directory('templates/backgrounds'),
            ];
        }
        
        return $fields;
    }

    public function hasColorSettingsEnabled()
    {
        return $this->backgroundSettings;
    }
}
