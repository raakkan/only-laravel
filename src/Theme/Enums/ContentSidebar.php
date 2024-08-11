<?php

namespace Raakkan\OnlyLaravel\Theme\Enums;

enum ContentSidebar: string
{
    case LEFT = 'left';
    case RIGHT = 'right';
    case BOTH = 'both';
}