<?php

namespace Raakkan\OnlyLaravel\Template\Blocks;

use Illuminate\Contracts\Support\Arrayable;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\HasType;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;
use Raakkan\OnlyLaravel\Support\Concerns\HasGroup;
use Raakkan\OnlyLaravel\Support\Concerns\HasLabel;
use Raakkan\OnlyLaravel\Template\Concerns\Addable;
use Raakkan\OnlyLaravel\Template\Concerns\HasModel;
use Raakkan\OnlyLaravel\Template\Concerns\HasOrder;
use Raakkan\OnlyLaravel\Template\Concerns\Sortable;
use Raakkan\OnlyLaravel\Template\Concerns\Deletable;
use Raakkan\OnlyLaravel\Template\Concerns\HasSource;
use Raakkan\OnlyLaravel\Template\Concerns\HasForPage;
use Raakkan\OnlyLaravel\Template\Concerns\Disableable;
use Raakkan\OnlyLaravel\Template\Concerns\HasLocation;
use Raakkan\OnlyLaravel\Template\Concerns\HasPageModel;
use Raakkan\OnlyLaravel\Template\Concerns\HasForTemplate;
use Raakkan\OnlyLaravel\Template\Blocks\Concerns\HasAssets;
use Raakkan\OnlyLaravel\Template\Concerns\HasBlockSettings;
use Raakkan\OnlyLaravel\Template\Blocks\Concerns\HasBlockView;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasBackgroundSettings;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasCustomStyleSettings;

abstract class BaseBlock implements Arrayable
{
    use Makable;
    use HasName;
    use HasLabel {
        getLabel as parentGetLabel;
    }
    use HasType;
    use HasGroup;
    use HasSource;
    use HasBlockSettings;
    use HasOrder;
    use HasLocation;
    use HasModel;
    use Deletable;
    use Sortable;
    use HasForTemplate;
    use Addable;
    use Disableable;
    use HasForPage;
    use HasBlockView;
    use HasPageModel;
    use HasAssets;
    use HasCustomStyleSettings;

    protected $parent;
    protected $templateModel;

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

    // public function __get($key)
    // {
    //     if ('settings' === $key) {
    //         return $this->settings;
    //     }

    //     $value = Arr::get($this->settings, $key);
    //     dd($value);

    //     return $value;
    // }


    public function getViewPaths()
    {
        return [];
    }
}