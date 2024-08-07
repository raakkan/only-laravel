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
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasModel;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\Sortable;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\Deletable;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasLocation;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasSettings;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasBlockComponents;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasBackgroundSettings;

class Block implements Arrayable
{
    use Makable;
    use HasName;
    use HasLabel {
        getLabel as parentGetLabel;
    }
    use HasType;
    use HasGroup;
    use HasSource;
    use HasBlockComponents;
    use HasSettings;
    use HasOrder;
    use HasLocation;
    use HasModel;
    use HasBackgroundSettings;
    use Deletable;
    use Sortable;
    
    protected $parent;
    protected $children = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getLabel()
    {
        return $this->hasLabel() ? $this->label : $this->name;
    }

    public function children($children)
    {
        $this->children = $children;
        return $this;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function parent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'label' => $this->label ?? $this->name,
            'source' => $this->source,
            'group' => $this->group,
            'order' => $this->order,
            'type' => $this->type ?? 'block',
        ];
    }

    public function create($template, $parent = null)
    {
        $order = $this->order;
        if ($parent) {
            $childCount = $template->blocks()->where('parent_id', $parent->id)->count();
            $order = $childCount === 0 ? 0 : $childCount++;
        }

        $block = $template->blocks()->create([
            'name' => $this->name,
            'template_id' => $template->id,
            'source' => $this->source,
            'order' => $order,
            'location' => $this->location,
            'type' => 'block',
            'parent_id' => $parent ? $parent->id : null
        ]);

        foreach ($this->components as $component) {
            $component->create($template, $block);
        }
    }
}