<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Blocks\Components;

use Illuminate\Contracts\Support\Arrayable;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\HasType;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;
use Raakkan\OnlyLaravel\Theme\Concerns\HasSource;
use Raakkan\OnlyLaravel\Support\Concerns\HasGroup;

abstract class BlockComponent implements Arrayable
{
    use Makable;
    use HasName;
    use HasType;
    use HasGroup;
    use HasSource;

    public function __construct($name)
    {
        $this->name = $name;
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
}