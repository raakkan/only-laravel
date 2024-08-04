<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Blocks\Items;

use Illuminate\Contracts\Support\Arrayable;
use Raakkan\OnlyLaravel\Support\Concerns\HasGroup;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\HasType;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;

abstract class BaseBlockItem implements Arrayable
{
    use Makable;
    use HasName;
    use HasType;
    use HasGroup;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
        ];
    }
}