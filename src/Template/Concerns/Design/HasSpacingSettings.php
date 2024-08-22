<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Illuminate\Support\Arr;
use Filament\Forms\Components\TextInput;
use Raakkan\OnlyLaravel\Filament\Components\MarginField;
use Raakkan\OnlyLaravel\Filament\Components\PaddingField;

trait HasSpacingSettings
{
    protected $paddingSettings = false;
    protected $paddingLeftSettings = false;
    protected $paddingRightSettings = false;
    protected $paddingTopSettings = false;
    protected $paddingBottomSettings = false;
    protected $marginSettings = false;
    protected $marginLeftSettings = false;
    protected $marginRightSettings = false;
    protected $marginTopSettings = false;
    protected $marginBottomSettings = false;
    protected $spacingResponsiveSettings = false;

    public $spacingSettings = [
        'padding' => [
            'padding' => 0,
            'small' => 0,
            'medium' => 0,
            'large' => 0,
            'extra_large' => 0,
            '2_extra_large' => 0,
            'left' => [
                'padding' => 0,
                'small' => 0,
                'medium' => 0,
                'large' => 0,
                'extra_large' => 0,
                '2_extra_large' => 0,
            ],
            'right' => [
                'padding' => 0,
                'small' => 0,
                'medium' => 0,
                'large' => 0,
                'extra_large' => 0,
                '2_extra_large' => 0,
            ],
            'top' => [
                'padding' => 0,
                'small' => 0,
                'medium' => 0,
                'large' => 0,
                'extra_large' => 0,
                '2_extra_large' => 0,
            ],
            'bottom' => [
                'padding' => 0,
                'small' => 0,
                'medium' => 0,
                'large' => 0,
                'extra_large' => 0,
                '2_extra_large' => 0,
            ],
        ],
        'margin' => [
            'margin' => 0,
            'small' => 0,
            'medium' => 0,
            'large' => 0,
            'extra_large' => 0,
            '2_extra_large' => 0,
            'left' => [
                'margin' => 0,
                'small' => 0,
                'medium' => 0,
                'large' => 0,
                'extra_large' => 0,
                '2_extra_large' => 0,
            ],
            'right' => [
                'margin' => 0,
                'small' => 0,
                'medium' => 0,
                'large' => 0,
                'extra_large' => 0,
                '2_extra_large' => 0,
            ],
            'top' => [
                'margin' => 0,
                'small' => 0,
                'medium' => 0,
                'large' => 0,
                'extra_large' => 0,
                '2_extra_large' => 0,
            ],
            'bottom' => [
                'margin' => 0,
                'small' => 0,
                'medium' => 0,
                'large' => 0,
                'extra_large' => 0,
                '2_extra_large' => 0,
            ],
        ],
    ];

    public function setSpacingSettings($settings)
    {
        if (array_key_exists('spacing', $settings)) {
            Arr::set($this->spacingSettings, 'padding', $settings['spacing']['padding']);
            Arr::set($this->spacingSettings, 'margin', $settings['spacing']['margin']);
        }
    }

    public function getPadding($name)
    {
        return Arr::get($this->spacingSettings, 'padding.' . $name);
    }

    public function getMargin($name)
    {
        return Arr::get($this->spacingSettings, 'margin.' . $name);
    }

    public function getSpacingSettingFields()
    {
        $fields = [];

        if ($this->paddingSettings) {
            if ($this->spacingResponsiveSettings) {
                $fields[] = PaddingField::make('onlylaravel.spacing.padding')->label('Padding');
            } else {
                $fields[] = TextInput::make('onlylaravel.spacing.padding.padding')->label('Padding')->numeric()->extraAttributes(['style' => 'padding:0;']);
            };
        }

        if ($this->paddingLeftSettings) {
            if ($this->spacingResponsiveSettings) {
                $fields[] = PaddingField::make('onlylaravel.spacing.padding.left')->label('Padding Left');
            } else {
                $fields[] = TextInput::make('onlylaravel.spacing.padding.left.padding')->label('Padding Left')->numeric()->extraAttributes(['style' => 'padding:0;']);
            };
        }

        if ($this->paddingRightSettings) {
            if ($this->spacingResponsiveSettings) {
                $fields[] = PaddingField::make('onlylaravel.spacing.padding.right')->label('Padding Right');
            } else {
                $fields[] = TextInput::make('onlylaravel.spacing.padding.right.padding')->label('Padding Right')->numeric()->extraAttributes(['style' => 'padding:0;']);
            };
        }

        if ($this->paddingTopSettings) {
            if ($this->spacingResponsiveSettings) {
                $fields[] = PaddingField::make('onlylaravel.spacing.padding.top')->label('Padding Top');
            } else {
                $fields[] = TextInput::make('onlylaravel.spacing.padding.top.padding')->label('Padding Top')->numeric()->extraAttributes(['style' => 'padding:0;']);
            };
        }

        if ($this->paddingBottomSettings) {
            if ($this->spacingResponsiveSettings) {
                $fields[] = PaddingField::make('onlylaravel.spacing.padding.bottom')->label('Padding Bottom');
            } else {
                $fields[] = TextInput::make('onlylaravel.spacing.padding.bottom.padding')->label('Padding Bottom')->numeric()->extraAttributes(['style' => 'padding:0;']);
            };
        }

        if ($this->marginSettings) {
            if ($this->spacingResponsiveSettings) {
                $fields[] = MarginField::make('onlylaravel.spacing.margin')->label('Margin');
            } else {
                $fields[] = TextInput::make('onlylaravel.spacing.margin.margin')->label('Margin')->numeric()->extraAttributes(['style' => 'padding:0;']);
            };
        }

        if ($this->marginLeftSettings) {
            if ($this->spacingResponsiveSettings) {
                $fields[] = MarginField::make('onlylaravel.spacing.margin.left')->label('Margin Left');
            } else {
                $fields[] = TextInput::make('onlylaravel.spacing.margin.left.margin')->label('Margin Left')->numeric()->extraAttributes(['style' => 'padding:0;']);
            };
        }

        if ($this->marginRightSettings) {
            if ($this->spacingResponsiveSettings) {
                $fields[] = MarginField::make('onlylaravel.spacing.margin.right')->label('Margin Right');
            } else {
                $fields[] = TextInput::make('onlylaravel.spacing.margin.right.margin')->label('Margin Right')->numeric()->extraAttributes(['style' => 'padding:0;']);
            };
        }

        if ($this->marginTopSettings) {
            if ($this->spacingResponsiveSettings) {
                $fields[] = MarginField::make('onlylaravel.spacing.margin.top')->label('Margin Top');
            } else {
                $fields[] = TextInput::make('onlylaravel.spacing.margin.top.margin')->label('Margin Top')->numeric()->extraAttributes(['style' => 'padding:0;']);
            };
        }

        if ($this->marginBottomSettings) {
            if ($this->spacingResponsiveSettings) {
                $fields[] = MarginField::make('onlylaravel.spacing.margin.bottom')->label('Margin Bottom');
            } else {
                $fields[] = TextInput::make('onlylaravel.spacing.margin.bottom.margin')->label('Margin Bottom')->numeric()->extraAttributes(['style' => 'padding:0;']);
            };
        }

        return $fields;
    }

    public function hasSpacingSettingsEnabled()
    {
        return $this->paddingSettings || $this->marginSettings;
    }
}
