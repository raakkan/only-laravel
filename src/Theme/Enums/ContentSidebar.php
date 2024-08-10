<?php

namespace Raakkan\OnlyLaravel\Theme\Enums;

enum ContentSidebar: string
{
    case LEFT = 'left';
    case RIGHT = 'right';

    public function options(): array
    {
        return [
            self::LEFT => 'Left',
            self::RIGHT => 'Right',
        ];
    }
}