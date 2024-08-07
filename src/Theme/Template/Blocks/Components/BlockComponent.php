<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Blocks\Components;

use Illuminate\Contracts\Support\Arrayable;
use Raakkan\OnlyLaravel\Theme\Concerns\HasOrder;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\HasType;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;
use Raakkan\OnlyLaravel\Theme\Concerns\HasSource;
use Raakkan\OnlyLaravel\Support\Concerns\HasGroup;
use Raakkan\OnlyLaravel\Support\Concerns\HasLabel;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasModel;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\Sortable;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\Deletable;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasLocation;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasSettings;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasBackgroundSettings;

abstract class BlockComponent implements Arrayable
{
    use Makable;
    use HasName;
    use HasType;
    use HasGroup;
    use HasSource;
    use HasOrder;
    use HasLocation;
    use HasLabel {
        getLabel as parentGetLabel;
    }
    use HasModel;
    use HasBackgroundSettings;
    use HasSettings;
    use Deletable;
    use Sortable;
    protected $model;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getLabel()
    {
        return $this->hasLabel() ? $this->label : $this->name;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'type' => $this->type ?? 'component',
            'group' => $this->group,
            'source' => $this->source,
        ];
    }

    public function create($template, $parent = null)
    {
        $childCount = $template->blocks()->where('parent_id', $parent ? $parent->id : null)->where('location', $this->location)->count();

        $block = $template->blocks()->create([
            'name' => $this->name,
            'template_id' => $template->id,
            'source' => $this->source,
            'order' => $childCount === 0 ? 0 : $childCount++,
            'location' => $this->location,
            'type' => 'component',
            'parent_id' => $parent ? $parent->id : null
        ]);
    }
}