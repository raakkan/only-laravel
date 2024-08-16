<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

trait HasForTemplate
{
    protected $forTemplate = 'all';

    public function forTemplate($forTemplate)
    {
        $this->forTemplate = $forTemplate;
        return $this;
    }

    public function getForTemplate()
    {
        return $this->forTemplate;
    }

    public function setForTemplate($forTemplate)
    {
        $this->forTemplate = $forTemplate;
    }
}