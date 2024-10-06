<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Set;
use Illuminate\Support\Arr;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ColorPicker;
use Raakkan\OnlyLaravel\Facades\FontManager;
use Filament\Forms\Components\Actions\Action;

trait HasTextSettings
{
    protected $fontFamilies = [
        [
            'name' => 'Arial',
            'value' => 'Arial, sans-serif'
        ],
        [
            'name' => 'Helvetica',
            'value' => 'Helvetica, Arial, sans-serif'
        ],
        [
            'name' => 'Verdana',
            'value' => 'Verdana, Geneva, sans-serif'
        ],
        [
            'name' => 'Tahoma',
            'value' => 'Tahoma, Geneva, sans-serif'
        ],
        [
            'name' => 'Times New Roman',
            'value' => '"Times New Roman", Times, serif'
        ],
        [
            'name' => 'Georgia',
            'value' => 'Georgia, serif'
        ],
        [
            'name' => 'Courier New',
            'value' => '"Courier New", Courier, monospace'
        ],
        [
            'name' => 'Roboto',
            'value' => 'Roboto, Arial, sans-serif'
        ],
    ];
    protected $fontFamilySetting = true;
    protected $textColorSetting = true;
    protected $fontSizeSetting = true;

    public function getTextSettingFields()
    {
        $fields = [];

        if ($this->fontFamilySetting) {
            $fields[] = TextInput::make('onlylaravel.text.font.family')
                ->label('Font Family')
                ->default('Arial, sans-serif');
        }

        if ($this->textColorSetting) {
            $fields[] = ColorPicker::make('onlylaravel.text.color')
            ->label('Text Color')
            ->hintAction(
                Action::make('clear')
                    ->label('Clear')
                    ->icon('heroicon-m-x-circle')
                    ->action(function (Set $set) {
                        $set('onlylaravel.text.color', '');
                    })
            );
            $fields[] = ColorPicker::make('onlylaravel.text.color_dark')
            ->label('Text Color (Dark)')
            ->hintAction(
                Action::make('clear')
                    ->label('Clear')
                    ->icon('heroicon-m-x-circle')
                    ->action(function (Set $set) {
                        $set('onlylaravel.text.color_dark', '');
                    })
            );
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

    public function getTextSetting($key)
    {
        return Arr::get($this->settings, 'onlylaravel.text.'. $key);
    }

    public function getTextColor()
    {
        return Arr::get($this->settings, 'onlylaravel.text.color', '#000000');
    }

    public function getTextColorDark()
    {
        return Arr::get($this->settings, 'onlylaravel.text.color_dark', '#ffffff');
    }

    public function getTextFontFamily()
    {
        return Arr::get($this->settings, 'onlylaravel.text.font.family', 'Inter');
    }

    public function getTextFontSize()
    {
        return Arr::get($this->settings, 'onlylaravel.text.font.size', '16px');
    }

    public function textColor($color, $darkColor = null)
    {
        $this->textColorSetting = true;
        Arr::set($this->settings, 'onlylaravel.text.color', $color);
        if ($darkColor) {
            Arr::set($this->settings, 'onlylaravel.text.color_dark', $darkColor);
        }
        return $this;
    }

    public function getTextColorStyles()
    {
        $styles = [];

        $textColor = $this->getTextColor();
        $textColorDark = $this->getTextColorDark();

        if ($textColor) {
            $styles[] = ".text-{$this->getName()} { color: {$textColor} }";
        }

        if ($textColorDark) {
            $styles[] = ".dark\\:text-{$this->getName()}:where(.dark, .dark *) { color: {$textColorDark} }";
        }

        return implode("\n", $styles);
    }

    public function getTextColorClasses()
    {
        $classes = [];

        if ($this->textColorSetting) {
            $classes[] = "text-{$this->getName()}";
            $classes[] = "dark:text-{$this->getName()}";
        }

        return implode(' ', $classes);
    }

    public function getTextFontFamilyStyles()
    {
        $styles = [];

        $fontFamily = $this->getTextFontFamily();
        $fontSize = $this->getTextFontSize();

        if ($fontFamily) {
            $styles[] = "font-family: {$fontFamily};";
        }

        if ($fontSize) {
            $styles[] = "font-size: {$fontSize};";
        }
        
        return implode("\n", $styles);
    }
}
