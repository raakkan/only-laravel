<?php

namespace Raakkan\OnlyLaravel\Template\Blocks;

use Illuminate\Contracts\Support\Arrayable;
use Raakkan\OnlyLaravel\Support\Concerns\HasGroup;
use Raakkan\OnlyLaravel\Support\Concerns\HasLabel;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\HasType;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;
use Raakkan\OnlyLaravel\Template\Blocks\Concerns\HasAssets;
use Raakkan\OnlyLaravel\Template\Blocks\Concerns\HasBlockView;
use Raakkan\OnlyLaravel\Template\Blocks\Concerns\HasDummyState;
use Raakkan\OnlyLaravel\Template\Concerns\Addable;
use Raakkan\OnlyLaravel\Template\Concerns\Deletable;
use Raakkan\OnlyLaravel\Template\Concerns\Disableable;
use Raakkan\OnlyLaravel\Template\Concerns\HasBlockSettings;
use Raakkan\OnlyLaravel\Template\Concerns\HasCustomStyleSettings;
use Raakkan\OnlyLaravel\Template\Concerns\HasForTemplate;
use Raakkan\OnlyLaravel\Template\Concerns\HasLocation;
use Raakkan\OnlyLaravel\Template\Concerns\HasModel;
use Raakkan\OnlyLaravel\Template\Concerns\HasOrder;
use Raakkan\OnlyLaravel\Template\Concerns\HasPageModel;
use Raakkan\OnlyLaravel\Template\Concerns\Sortable;

abstract class BaseBlock implements Arrayable
{
    use Addable;
    use Deletable;
    use Disableable;
    use HasAssets;
    use HasBlockSettings;
    use HasBlockView;
    use HasCustomStyleSettings;
    use HasDummyState;
    use HasForTemplate;
    use HasGroup;
    use HasLabel {
        getLabel as parentGetLabel;
    }
    use HasLocation;
    use HasModel;
    use HasName;
    use HasOrder;
    use HasPageModel;
    use HasType;
    use Makable;
    use Sortable;

    protected $parent;

    protected $templateModel;

    protected $otherCssClasses = '';

    protected $acceptDropChild = true;

    public function getTemplateModel()
    {
        return $this->templateModel;
    }

    public function setTemplateModel($templateModel)
    {
        $this->templateModel = $templateModel;

        return $this;
    }

    public function getLabel()
    {
        return $this->hasLabel() ? $this->label : $this->name;
    }

    public function parent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    public function isAcceptDropChild()
    {
        return $this->acceptDropChild;
    }

    public function setAcceptDropChild($acceptDropChild = true)
    {
        $this->acceptDropChild = $acceptDropChild;

        return $this;
    }

    public function getOtherCssClasses()
    {
        return $this->otherCssClasses;
    }

    public function setOtherCssClasses($otherCssClasses)
    {
        $this->otherCssClasses = $otherCssClasses;

        return $this;
    }

    public function addOtherCssClass($class)
    {
        $this->otherCssClasses .= ' '.$class;

        return $this;
    }
}
