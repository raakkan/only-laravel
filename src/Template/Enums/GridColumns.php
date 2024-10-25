<?php

namespace Raakkan\OnlyLaravel\Template\Enums;

enum GridColumns: string
{
    case ONE = '1';
    case TWO = '2';
    case THREE = '3';
    case FOUR = '4';

    public function getColumnClasses(): array
    {
        return match ($this) {
            self::ONE => ['w-full'],
            self::TWO => ['w-full md:w-1/2'],
            self::THREE => ['w-full md:w-1/3'],
            self::FOUR => ['w-full sm:w-1/2 lg:w-1/4'],
        };
    }

    public function getGridClasses(): string
    {
        return match ($this) {
            self::ONE => 'grid-cols-1',
            self::TWO => 'grid-cols-1 md:grid-cols-2',
            self::THREE => 'grid-cols-1 md:grid-cols-3',
            self::FOUR => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
        };
    }

    public static function options(): array
    {
        return [
            self::ONE->value => 'One Column',
            self::TWO->value => 'Two Columns',
            self::THREE->value => 'Three Columns',
            self::FOUR->value => 'Four Columns',
        ];
    }
}
