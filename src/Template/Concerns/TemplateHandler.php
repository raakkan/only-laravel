<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

use Raakkan\OnlyLaravel\Facades\OnlyLaravel;
use Raakkan\OnlyLaravel\Models\TemplateModel;

trait TemplateHandler
{
    protected $templates = [];

    public function getTemplate($name)
    {
        return $this->getTemplateByName($name);
    }

    public function getTemplates()
    {
        return $this->templates;
    }

    public function getTemplateByName($name)
    {
        return collect($this->getTemplates())->first(function ($template) use ($name) {
            return $template->getName() == $name;
        });
    }

    public function findTemplate($name)
    {
        return $this->getTemplateByName($name);
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