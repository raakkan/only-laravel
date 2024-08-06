<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Concerns;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;

trait HasSettings
{
    protected $settings = [];

    public function settings($settings)
    {
        $this->settings = $settings;
        return $this;
    }

    public function addSetting($setting)
    {
        $this->settings[] = $setting;
        return $this;
    }

    public function getSettings()
    {
        return [
            Section::make('Backround')
                ->schema([
                    TextInput::make('name')->required(),
                ])
        ];
    }
}