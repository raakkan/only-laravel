<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Illuminate\Support\Arr;
use Filament\Forms\Components\Section;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ColorPicker;
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
                ColorPicker::make('onlylaravel.background.color')->label('Background Color')->default($this->getBackgroundColor()),
            ];
        }

        if ($this->backgroundType == BackgroundType::IMAGE) {
            $fields = [
                FileUpload::make('onlylaravel.background.image')->label('Background Image')->image()->storeFileNamesIn('attachment_file_names')->directory('templates/backgrounds')->default($this->getBackgroundImage()),
            ];
        }

        if ($this->backgroundType == BackgroundType::BOTH) {
            $fields = [
                ColorPicker::make('onlylaravel.background.color')->label('Background Color')->default($this->getBackgroundColor())->rgba(),
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

    public function hasBackgroundSettingsEnabled()
    {
        return $this->backgroundSettings;
    }

    public function backgroundColor($color)
    {
        $this->backgroundType = BackgroundType::COLOR;
        $this->backgroundSettings = true;
        Arr::set($this->settings, 'onlylaravel.background.color', $color);
        return $this;
    }

    public function backgroundImage($image)
    {
        $this->backgroundType = BackgroundType::IMAGE;
        $this->backgroundSettings = true;
        Arr::set($this->settings, 'onlylaravel.background.image', $image);
        return $this;
    }

    public function background($color, $image = '')
    {
        $this->backgroundSettings = true;
        $this->backgroundType = BackgroundType::BOTH;
        Arr::set($this->settings, 'onlylaravel.background.color', $color);
        Arr::set($this->settings, 'onlylaravel.background.image', $image);
        
        return $this;
    }

    public function getBackgroundStyle()
    {
        $style = '';
        if ($this->hasBackgroundSettingsEnabled()) {
            if ($this->getBackgroundColor()) {
                $style = ' background-color: '. $this->getBackgroundColor(). ';';
            }
            if ($this->getBackgroundImage()) {
                $style.= ' background-image: url('. Storage::url($this->getBackgroundImage()). ');';
            }
        }
        return $style;
    }
}
