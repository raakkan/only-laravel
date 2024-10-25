<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

use Raakkan\OnlyLaravel\Template\Models\TemplateModel;

trait ManageTemplateParent
{
    protected $isParent = false;

    protected $parentTemplate;

    protected $useParentHeader = false;

    protected $useParentContent = false;

    protected $useParentFooter = false;

    public function parent($value = true)
    {
        $this->isParent = $value;

        return $this;
    }

    public function parentTemplate(TemplateModel $template)
    {
        $this->parentTemplate = $template;

        return $this;
    }

    public function useParentHeader($value = true)
    {
        $this->useParentHeader = $value;

        return $this;
    }

    public function useParentContent($value = true)
    {
        $this->useParentContent = $value;

        return $this;
    }

    public function useParentFooter($value = true)
    {
        $this->useParentFooter = $value;

        return $this;
    }
}
