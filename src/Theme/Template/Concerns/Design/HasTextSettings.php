<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Concerns\Design;

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

    public function getFontSettingFields()
    {
        $fields = [];

        if ($this->fontSettings) {
            $fields[] = Select::make('text.font.family')
            ->label('Font Family')
            ->options($this->availableFontFamilies)
            ->default($this->fontFamily);
            $fields[] = TextInput::make('text.font.size')->label('Font Size')->numeric()->default($this->fontSize) ->helperText('size in rem');
            $fields[] = TextInput::make('text.font.weight')->label('Font Weight')->default($this->fontWeight);
            $fields[] = Select::make('text.font.style')->label('Font Style')->options(['normal' => 'Normal', 'italic' => 'Italic'])->default($this->fontStyle);
            $fields[] = TextInput::make('text.font.latterSpacing')->label('Latter Spacing')->numeric()->default($this->latterSpacing)->helperText('size in rem');
            $fields[] = TextInput::make('text.font.lineHeight')->label('Line Height')->numeric()->default($this->lineHeight)->helperText('size in rem');
        }

        return [
            Section::make('Font Settings')->schema($fields)->compact()
        ];
    }

    public function hasFontSettings()
    {
        return $this->fontSettings;
    }
}
