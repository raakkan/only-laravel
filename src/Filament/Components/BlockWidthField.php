<?php

namespace Raakkan\OnlyLaravel\Filament\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class BlockWidthField extends Field
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
                    Select::make('unit')
                        ->label('Unit')
                        ->options([
                            '%' => 'Percentage',
                            'px' => 'Pixels',
                        ])->extraAttributes(['style' => 'padding:0;']),
                    TextInput::make($name)->label('Width')->numeric()->extraAttributes(['style' => 'padding:0;']),
                ])->columns(2)->compact()->extraAttributes(['style' => 'padding:0;']),
        ]);
    }
}
