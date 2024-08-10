<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Concerns;

use Raakkan\OnlyLaravel\Theme\Template\Template;
use Raakkan\OnlyLaravel\Theme\Models\ThemeTemplate;

trait TemplateHandler
{
    protected $templates = [];

    public function getTemplate($name)
    {
        $template = ThemeTemplate::where('name', $name)->first();

        if (!$template) {
            return null;
        }

        return $this->getTemplateByName($name)->setModelData($template);
    }

    public function getTemplates()
    {
        if (empty($this->templates)) {
            $this->templates = $this->getActiveTheme()->getTemplates();
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