<?php

namespace Raakkan\OnlyLaravel\Page\Concerns;

use Raakkan\OnlyLaravel\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Models\TemplateModel;

trait HasTemplate
{
    protected $template;

    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    public function hasTemplate()
    {
        return !empty($this->template);
    }

    public function template($name)
    {
        return $this->setTemplate($name);
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function getTemplateModel()
    {
        return TemplateModel::where('name', $this->template)->first();
    }
}