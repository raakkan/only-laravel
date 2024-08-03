<?php

declare(strict_types=1);

namespace Raakkan\OnlyLaravel\Theme\Events;

use Raakkan\OnlyLaravel\Theme\Theme;

class ThemeEnabling
{
    public Theme $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }
}
