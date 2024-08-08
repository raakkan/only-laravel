<?php

namespace Raakkan\OnlyLaravel\Theme\Concerns;

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
        if (!$this->hasSource()) {
            $this->source = $this->getActiveTheme()->getNamespace();
        }

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