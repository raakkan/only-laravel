<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

trait HasForTheme
{
    protected $forTheme = 'all';

    public function forTheme($forTheme)
    {
        $this->forTheme = $forTheme;
        return $this;
    }

    public function getForTheme()
    {
        return $this->forTheme;
    }

    public function setForTheme($forTheme)
    {
        $this->forTheme = $forTheme;
    }
}