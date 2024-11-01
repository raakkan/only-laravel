<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

use Illuminate\Support\Arr;
use Raakkan\OnlyLaravel\Admin\Forms\Components\Textarea;

trait HasCustomStyleSettings
{
    protected $customStyleSettings = true;

    protected $customCssSettings = true;

    public function getCustomStyle()
    {
        return Arr::get($this->settings, 'onlylaravel.custom_style', '');
    }

    public function getCustomCss()
    {
        return Arr::get($this->settings, 'onlylaravel.custom_css', '');
    }

    public function getCustomStyleSettingFields()
    {
        $fields = [];

        if ($this->customStyleSettings) {
            $fields[] = Textarea::make('onlylaravel.custom_style')->label('Custom Style')->rows(4)->default($this->getCustomStyle());
        }

        if ($this->customCssSettings) {
            $fields[] = Textarea::make('onlylaravel.custom_css')->label('Custom CSS')->rows(4)->default($this->getCustomCss());
        }

        return $fields;
    }

    public function hasCustomStyleSettingsEnabled()
    {
        return $this->customStyleSettings || $this->customCssSettings;
    }

    public function customStyle($style = '')
    {
        $this->customStyleSettings = true;
        Arr::set($this->settings, 'onlylaravel.custom_style', $style);

        return $this;
    }

    public function customCss($css = '')
    {
        $this->customCssSettings = true;
        Arr::set($this->settings, 'onlylaravel.custom_css', $css);

        return $this;
    }
}
