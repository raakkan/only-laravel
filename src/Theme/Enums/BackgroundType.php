<?php

namespace Raakkan\OnlyLaravel\Theme\Enums;

enum BackgroundType: string
{
    case COLOR = 'color';
    case IMAGE = 'image';
    case BOTH = 'both';
}