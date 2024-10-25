<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

trait HasForTemplate
{
    protected $forTemplates = ['all'];

    public function forTemplates($forTemplates)
    {
        $this->forTemplates = is_array($forTemplates) ? $forTemplates : [$forTemplates];

        return $this;
    }

    public function getForTemplates()
    {
        return $this->forTemplates;
    }

    public function setForTemplates($forTemplates)
    {
        $this->forTemplates = is_array($forTemplates) ? $forTemplates : [$forTemplates];
    }

    public function addForTemplate($forTemplate)
    {
        if (! in_array($forTemplate, $this->forTemplates)) {
            $this->forTemplates[] = $forTemplate;
        }

        return $this;
    }

    public function removeForTemplate($forTemplate)
    {
        $this->forTemplates = array_diff($this->forTemplates, [$forTemplate]);

        return $this;
    }
}
