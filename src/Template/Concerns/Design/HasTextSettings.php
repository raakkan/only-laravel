<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;

trait HasTextSettings
{
    protected $fontSettings = false;
    public $fontFamily = null;
    public $fontSize = null;
    public $fontWeight = null;
    public $fontStyle = 'normal';
    public $latterSpacing = null;
    public $lineHeight = null;

    protected $availableFontFamilies = [
        'Arial' => 'Arial',
        'Helvetica' => 'Helvetica',
        'Times New Roman' => 'Times New Roman',
        'Courier New' => 'Courier New',
        'Verdana' => 'Verdana',
        // Add more font families as needed
    ];
    

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
            $fields[] = Select::make('fontFamily')
            ->label('Font Family')
            ->options($this->availableFontFamilies)
            ->default($this->fontFamily);
            $fields[] = TextInput::make('fontSize')->label('Font Size')->numeric()->default($this->fontSize) ->helperText('size in rem')->live(debounce: 500);
            $fields[] = TextInput::make('fontWeight')->label('Font Weight')->default($this->fontWeight)->live(debounce: 500);
            $fields[] = Select::make('fontStyle')->label('Font Style')->options(['normal' => 'Normal', 'italic' => 'Italic'])->default($this->fontStyle)->live(debounce: 500);
            $fields[] = TextInput::make('letterSpacing')->label('Latter Spacing')->numeric()->default($this->latterSpacing)->helperText('size in rem')->live(debounce: 500);
            $fields[] = TextInput::make('lineHeight')->label('Line Height')->numeric()->default($this->lineHeight)->helperText('size in rem')->live(debounce: 500);
        }

        return $fields;
    }

    public function hasTextSettings()
    {
        return $this->fontSettings;
    }
}
