<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Blocks;

use Illuminate\Contracts\Support\Arrayable;
use Raakkan\OnlyLaravel\Support\Concerns\HasLabel;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;

class Block implements Arrayable
{
    use Makable;
    use HasName;
    use HasLabel;

    protected $source;
    protected $order;
    protected $settings = [];
    protected $items = [];
    protected $parent;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function source($source)
    {
        $this->source = $source;
        return $this;
    }

    public function order($order)
    {
        $this->order = $order;
        return $this;
    }

    public function settings($settings)
    {
        $this->settings = $settings;
        return $this;
    }

    public function items($items)
    {
        $this->items = $items;
        return $this;
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
            'label' => $this->label,
            'source' => $this->source,
            'order' => $this->order,
            'settings' => $this->settings,
            'items' => $this->items,
        ];
    }
}