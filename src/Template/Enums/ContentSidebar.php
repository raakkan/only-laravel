<?php

namespace Raakkan\OnlyLaravel\Template\Enums;

enum ContentSidebar: string
{
    case LEFT = 'left';
    case RIGHT = 'right';
    case BOTH = 'both';
}