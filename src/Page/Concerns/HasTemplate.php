<?php

namespace Raakkan\OnlyLaravel\Page\Concerns;

use Raakkan\OnlyLaravel\Template\Models\TemplateModel;
use Raakkan\OnlyLaravel\Template\PageTemplate;

trait HasTemplate
{
    protected $template;

    protected $templateModel;

    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    public function hasTemplate()
    {
        return ! empty($this->template);
    }

    public function template(PageTemplate $template)
    {
        return $this->setTemplate($template);
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function getTemplateModel()
    {
        if (empty($this->templateModel)) {
            $this->templateModel = TemplateModel::where('name', $this->template->getName())->first();
        }

        return $this->templateModel;
    }

    public function createTemplate()
    {
        return $this->template->create();
    }
}
