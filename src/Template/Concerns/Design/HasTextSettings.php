<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ColorPicker;
use Raakkan\OnlyLaravel\Facades\FontManager;

trait HasTextSettings
{
    protected $fontFamilySetting = true;
    protected $textColorSetting = true;
    protected $fontSizeSetting = true;

    public function getTextSettingFields()
    {
        $fields = [];

        if ($this->fontFamilySetting) {
            $fields[] = Select::make('onlylaravel.text.font.family')
            ->label('Font Family')
            ->options(collect(FontManager::getFontFamilies())->mapWithKeys(function ($value, $key) {
                return [$value['value'] => $value['name']];
            })->toArray());
        }

        if ($this->textColorSetting) {
            $fields[] = ColorPicker::make('onlylaravel.text.color')
            ->label('Text Color');
        }

        if ($this->fontSizeSetting) {
            $fields[] = TextInput::make('onlylaravel.text.font.size')
            ->label('Font Size')->numeric();
        }

        return $fields;
    }

    public function hasTextSettingsEnabled()
    {
        return $this->fontFamilySetting || $this->fontSizeSetting || $this->fontWeightSetting;
    }
}
