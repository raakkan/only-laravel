<?php

namespace Raakkan\OnlyLaravel\Theme\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

trait HasFilamentPages
{
    public function getFilamentPages(): array
    {
        if ($this->hasThemeClass()) {
            return $this->themeClass::getFilamentPages();
        }

        return [];
    }
}
