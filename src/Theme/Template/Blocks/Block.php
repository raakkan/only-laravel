<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Blocks;

use Illuminate\Contracts\Support\Arrayable;
use Raakkan\OnlyLaravel\Theme\Concerns\HasOrder;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;
use Raakkan\OnlyLaravel\Theme\Concerns\HasSource;
use Raakkan\OnlyLaravel\Support\Concerns\HasGroup;
use Raakkan\OnlyLaravel\Support\Concerns\HasLabel;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasSettings;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasBlockComponents;

class Block implements Arrayable
{
    use Makable;
    use HasName;
    use HasLabel;
    use HasGroup;
    use HasSource;
    use HasBlockComponents;
    use HasSettings;
    use HasOrder;
    
    protected $parent;

    public function __construct($name)
    {
        $this->name = $name;
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
        ];
    }
}