<?php

namespace Raakkan\OnlyLaravel\Filament\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;

class BlockResponsiveNumberField extends Field
{
    protected string $view = 'only-laravel::filament.components.spacing-field';

    protected function setUp(): void
    {
        $names = explode('.', $this->getName());
        $name = $names[1];
        $label = count($names) > 2 ? ucfirst($names[1]).' '.ucfirst($names[2]) : ucfirst($names[1]);

        $this->schema([
            Section::make($label)
                ->schema([
                    TextInput::make($name)->label('All')->numeric()->extraAttributes(['style' => 'padding:0;']),
                    TextInput::make('small')->label('Small')->numeric()->extraAttributes(['style' => 'padding:0;']),
                    TextInput::make('medium')->label('Medium')->numeric()->extraAttributes(['style' => 'padding:0;']),
                    TextInput::make('large')->label('Large')->numeric()->extraAttributes(['style' => 'padding:0;']),
                    TextInput::make('extra_large')->label('Extra Large')->inputMode('numeric')->numeric()->extraAttributes(['style' => 'padding:0;']),
                    TextInput::make('2_extra_large')->label('2 Extra Large')->numeric()->extraAttributes(['style' => 'padding:0;']),
                ])->columns(2)->compact(),
        ]);
    }
}
