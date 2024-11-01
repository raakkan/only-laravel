<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

use Raakkan\OnlyLaravel\Template\Models\TemplateModel;

trait ManageTemplateParent
{
    protected $isParent = false;

    protected $parentTemplate;

    protected $parentBlocks = [];

    public function parent($value = true)
    {
        $this->isParent = $value;

        return $this;
    }

    public function parentTemplate($templateName)
    {
        // $parentTemplate = TemplateModel::where('name', $templateName)->first() ?? null;
        $this->parentTemplate = $templateName;

        return $this;
    }

    public function useParentBlock($blockName, $value = true)
    {
        $this->parentBlocks[$blockName] = $value;

        return $this;
    }

    public function useParentBlocks(array $blocks)
    {
        foreach ($blocks as $blockName => $value) {
            $this->parentBlocks[$blockName] = $value;
        }

        return $this;
    }

    public function shouldUseParentBlock($blockName)
    {
        return $this->parentBlocks[$blockName] ?? false;
    }
}
