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
use Raakkan\OnlyLaravel\Template\Concerns\Disableable;
use Raakkan\OnlyLaravel\Template\Concerns\HasForTheme;
use Raakkan\OnlyLaravel\Template\Concerns\HasLocation;
use Raakkan\OnlyLaravel\Template\Concerns\HasSettings;
use Raakkan\OnlyLaravel\Template\Concerns\HasForTemplate;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasTextSettings;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasColorSettings;

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
    use HasSettings;
    use HasOrder;
    use HasLocation;
    use HasModel;
    use HasColorSettings;
    use Deletable;
    use Sortable;
    use HasForTemplate;
    use HasForTheme;
    use Addable;
    use Disableable;
    use HasTextSettings;

    protected $parent;
    protected $view;
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

    public function render()
    {
        return view($this->view, [
            'block' => $this
        ]);
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
}