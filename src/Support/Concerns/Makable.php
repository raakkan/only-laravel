<?php

namespace Raakkan\OnlyLaravel\Support\Concerns;

trait Makable
{
    public static function make(...$arguments): static
    {
        $instance = new static(...$arguments);

        return $instance;
    }
}