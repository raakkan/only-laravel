<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

trait TemplateHandler
{
    protected $templates = [];

    public function getTemplates()
    {
        return $this->templates;
    }

    public function registerTemplates($templates)
    {
        $this->templates = array_merge($this->templates, $templates);

        return $this;
    }

    public function createTemplates()
    {
        foreach ($this->getTemplates() as $template) {
            $template->create();
        }
    }
}
