<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Raakkan\OnlyLaravel\Facades\FontManager;

trait HasTextSettings
{
    protected $fontFamilySetting = true;
    public $fontFamily = null;
    public $fontSizeSetting = true;
    public $fontSize = null;
    public $fontWeightSetting = false;
    public $fontWeight = null;
    public $fontStyleSetting = false;
    public $fontStyle = 'normal';
    public $latterSpacingSetting = false;
    public $latterSpacing = null;
    public $lineHeightSetting = false;
    public $lineHeight = null;

    public function getTextSettingFields()
    {
        $fields = [];

        if ($this->fontFamilySetting) {
            $fields[] = Select::make('text.font.family')
            ->label('Font Family')
            ->options(collect(FontManager::getFontFamilies())->mapWithKeys(function ($value, $key) {
                return [$value['value'] => $value['name']];
            })->toArray())
            ->default($this->fontFamily)->live(debounce: 500);
        }

        if ($this->fontSizeSetting) {
            $fields[] = TextInput::make('text.font.size')
            ->label('Font Size')
            ->default($this->fontSize)->numeric();
        }

        if ($this->fontWeightSetting) {
            $fields[] = Select::make('text.font.weight')
            ->label('Font Weight')
            ->options(collect(FontManager::getFontWeights())->mapWithKeys(function ($value, $key) {
                return [$value['value'] => $value['name']];
            })->toArray())
            ->default($this->fontWeight);
        }

        if ($this->fontStyleSetting) {
            $fields[] = $fields[] = Select::make('text.font.style')->label('Font Style')->options(['normal' => 'Normal', 'italic' => 'Italic'])->default($this->fontStyle)->live(debounce: 500);
        }

        if ($this->latterSpacingSetting) {
            $fields[] = TextInput::make('text.font.latterSpacing')
            ->label('Latter Spacing')
            ->default($this->latterSpacing)->numeric();
        }

        if ($this->lineHeightSetting) {
            $fields[] = TextInput::make('text.font.lineHeight')
            ->label('Line Height')
            ->default($this->lineHeight)->numeric();
        }

        return $fields;
    }

    public function hasTextSettingsEnabled()
    {
        return $this->fontFamilySetting || $this->fontSizeSetting || $this->fontWeightSetting || $this->fontStyleSetting || $this->latterSpacingSetting || $this->lineHeightSetting;
    }

    public function setTextSettings($settings)
    {
        if (is_array($settings) && array_key_exists('text', $settings)) {
            $this->fontFamily = $settings['text']['font']['family'] ?? null;
            $this->fontSize = $settings['text']['font']['size'] ?? null;
            $this->fontWeight = $settings['text']['font']['weight'] ?? null;
            $this->fontStyle = $settings['text']['font']['style'] ?? null;
            $this->latterSpacing = $settings['text']['font']['latterSpacing'] ?? null;
            $this->lineHeight = $settings['text']['font']['lineHeight'] ?? null;
        }
        return $this;
    }

    public function fontFamilySetting()
    {
        $this->fontFamilySetting = true;
        return $this;
    }

    public function fontSizeSetting()
    {
        $this->fontSizeSetting = true;
        return $this;
    }

    public function fontWeightSetting()
    {
        $this->fontWeightSetting = true;
        return $this;
    }

    public function fontStyleSetting()
    {
        $this->fontStyleSetting = true;
        return $this;
    }

    public function latterSpacingSetting()
    {
        $this->latterSpacingSetting = true;
        return $this;
    }

    public function lineHeightSetting()
    {
        $this->lineHeightSetting = true;
        return $this;
    }
}
