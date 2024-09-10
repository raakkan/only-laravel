<?php

namespace Raakkan\OnlyLaravel\Plugin;

abstract class BasePlugin
{
    public function filamentResources(): array
    {
        return [];
    }

    public function filamentPages(): array
    {
        return [];
    }
}