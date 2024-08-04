<?php

namespace Raakkan\OnlyLaravel\Theme\Template;

use Illuminate\Contracts\Support\Arrayable;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;
use Raakkan\OnlyLaravel\Support\Concerns\HasLabel;
use Raakkan\OnlyLaravel\Theme\Template\Blocks\Block;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasBlocks;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasSettings;

class Template implements Arrayable
{
    use Makable;
    use HasName;
    use HasLabel;
    use HasBlocks;
    use HasSettings;

    protected $source;
    protected $for;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function source($source)
    {
        $this->source = $source;
        return $this;
    }

    public function for($for)
    {
        $this->for = $for;
        return $this;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'label' => $this->label,
            'source' => $this->source,
            'for' => $this->for,
            'settings' => $this->settings,
            'blocks' => $this->blocks,
        ];
    }
}