<?php

namespace Raakkan\OnlyLaravel;

class OnlyLaravelManager
{
    protected $templates = [];

    public function registerTemplates($templates)
    {
        $this->templates = array_merge($this->templates, $templates);
        return $this;
    }

    public function getTemplates()
    {
        return $this->templates;
    }
}
