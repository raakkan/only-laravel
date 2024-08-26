<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

use Raakkan\OnlyLaravel\Facades\OnlyLaravel;
use Raakkan\OnlyLaravel\Models\TemplateModel;

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