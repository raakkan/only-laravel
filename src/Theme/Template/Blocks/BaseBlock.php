<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Blocks;

use Illuminate\Contracts\Support\Arrayable;
use Raakkan\OnlyLaravel\Theme\Concerns\HasOrder;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\HasType;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;
use Raakkan\OnlyLaravel\Theme\Concerns\HasSource;
use Raakkan\OnlyLaravel\Support\Concerns\HasGroup;
use Raakkan\OnlyLaravel\Support\Concerns\HasLabel;
use Raakkan\OnlyLaravel\Theme\Facades\ThemesManager;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasForTemplate;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasForTheme;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasModel;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\Sortable;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\Deletable;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasLocation;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasSettings;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasBackgroundSettings;

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
    use HasBackgroundSettings;
    use Deletable;
    use Sortable;
    use HasForTemplate;
    use HasForTheme;

    protected $parent;

    public function __construct($name)
    {
        $this->name = $name;
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

    public function getActiveTheme()
    {
        return ThemesManager::current();
    }
}