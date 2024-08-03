<?php

namespace Raakkan\OnlyLaravel\Support\Concerns;

trait Makable
{
    protected $callerMetadata;

    public static function make(...$arguments): static
    {
        $instance = new static(...$arguments);

        return $instance;
    }
}