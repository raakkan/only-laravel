<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

use Raakkan\OnlyLaravel\Facades\OnlyLaravel;
use Raakkan\OnlyLaravel\Models\TemplateModel;

trait TemplateHandler
{
    protected $templates = [];

    public function getTemplate($name)
    {
        $template = TemplateModel::where('name', $name)->first();

        if (!$template) {
            $this->getTemplateByName($name)->create();
            $template = TemplateModel::where('name', $name)->first();
        }

        return $this->getTemplateByName($name)->setModelData($template);
    }

    public function getTemplates()
    {
        if (empty($this->templates)) {
            $this->templates = OnlyLaravel::getTemplates();
        }
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
}