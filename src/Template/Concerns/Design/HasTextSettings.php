<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Raakkan\OnlyLaravel\Facades\FontManager;

trait HasTextSettings
{
    protected $fontSettings = true;
    public $fontFamily = null;
    public $fontSize = null;
    public $fontWeight = null;
    public $fontStyle = 'normal';
    public $latterSpacing = null;
    public $lineHeight = null;

    public function fontSettings($fontFamily = null, $fontSize = null, $fontWeight = null, $fontStyle = 'normal', $latterSpacing = null, $lineHeight = null)
    {
        $this->fontSettings = true;
        $this->fontFamily = $fontFamily;
        $this->fontSize = $fontSize;
        $this->fontWeight = $fontWeight;
        $this->fontStyle = $fontStyle;
        $this->latterSpacing = $latterSpacing;
        $this->lineHeight = $lineHeight;
        return $this;
    }

    public function getTextSettingFields()
    {
        $fields = [];

        if ($this->fontSettings) {
            $fields[] = Select::make('text.font.family')
            ->label('Font Family')
            ->options(collect(FontManager::getFontFamilies())->mapWithKeys(function ($value, $key) {
                return [$value['value'] => $value['name']];
            })->toArray())
            ->default($this->fontFamily)->live(debounce: 500);
            $fields[] = TextInput::make('text.font.size')->label('Font Size')->numeric()->default($this->fontSize) ->helperText('size in rem')->live(debounce: 500);
            $fields[] = TextInput::make('text.font.weight')->label('Font Weight')->default($this->fontWeight)->live(debounce: 500);
            $fields[] = Select::make('text.font.style')->label('Font Style')->options(['normal' => 'Normal', 'italic' => 'Italic'])->default($this->fontStyle)->live(debounce: 500);
            $fields[] = TextInput::make('text.font.latterSpacing')->label('Latter Spacing')->numeric()->default($this->latterSpacing)->helperText('size in rem')->live(debounce: 500);
            $fields[] = TextInput::make('text.font.lineHeight')->label('Line Height')->numeric()->default($this->lineHeight)->helperText('size in rem')->live(debounce: 500);
        }

        return $fields;
    }

    public function hasTextSettingsEnabled()
    {
        return $this->fontSettings;
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
}
