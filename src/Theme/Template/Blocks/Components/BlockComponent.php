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
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasLocation;

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

    public $blockOrComponent = 'component';
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
            'type' => $this->type,
            'group' => $this->group,
            'source' => $this->source
        ];
    }

    public function create($template, $parent = null)
    {
        $childCount = $template->blocks()->where('parent_id', $parent ? $parent->id : null)->count();

        $block = $template->blocks()->create([
            'name' => $this->name,
            'template_id' => $template->id,
            'source' => $this->source,
            'order' => $childCount === 0 ? 0 : $childCount++,
            'locations' => json_encode([$this->location]),
            'location' => $this->location,
            'type' => $this->blockOrComponent,
            'parent_id' => $parent ? $parent->id : null
        ]);
    }
}