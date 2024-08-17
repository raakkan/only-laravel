<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

trait HasSource
{
    protected $source;

    public function source($source)
    {
        $this->source = $source;
        return $this;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function hasSource()
    {
        return isset($this->source);
    }

    public function setSource($source)
    {
        $this->source = $source;
    }
}