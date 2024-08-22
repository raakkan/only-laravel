<?php

namespace Raakkan\OnlyLaravel\Filament\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;

class PaddingField extends Field
{
    protected string $view = 'only-laravel::filament.components.spacing-field';

    protected function setUp(): void
    {
        $this->schema([
            Section::make($this->getLabel() == 'Padding' ? 'Padding' : 'Padding ' . $this->getLabel())
                ->schema([
                    TextInput::make('padding')->label('All')->numeric()->extraAttributes(['style' => 'padding:0;']),
                    TextInput::make('small')->label('Small')->numeric()->extraAttributes(['style' => 'padding:0;']),
                    TextInput::make('medium')->label('Medium')->numeric()->extraAttributes(['style' => 'padding:0;']),
                    TextInput::make('large')->label('Large')->numeric()->extraAttributes(['style' => 'padding:0;']),
                    TextInput::make('extra_large')->label('Extra Large')->numeric()->extraAttributes(['style' => 'padding:0;']),
                    TextInput::make('2extra_large')->label('2 Extra Large')->numeric()->extraAttributes(['style' => 'padding:0;']),
                ])->columns(2)->compact()
        ]);
    }
}
