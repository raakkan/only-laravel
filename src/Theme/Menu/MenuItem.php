<?php

namespace Raakkan\ThemesManager\Menu;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\Arrayable;
use Raakkan\ThemesManager\Support\Traits\HasIcon;
use Raakkan\ThemesManager\Support\Traits\HasName;
use Raakkan\ThemesManager\Support\Traits\HasLabel;

class MenuItem  implements Arrayable
{
    use HasName;
    use HasLabel { getLabel as protected; }
    use HasIcon;

    protected $url;
    protected $model;

    protected $parent;
    protected $children = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public static function make($name)
    {
        return new static($name);
    }

    public static function makeByModel($model, $parent = null)
    {
        $item = new static($model->name);

        $item->model = $model;
        $item->url = $model->url;

        if ($model->hasParent() && $parent) {
            $item->parent = $parent;
        }

        if ($model->hasChildren()) {
            foreach ($model->children as $child) {
                $item->children[] = MenuItem::makeByModel($child, $item);
            }
        }

        return $item;
    }

    public function getModelId()
    {
        return $this->model->id;
    }

    public function getLabel()
    {
        return $this->label ?? Str::headline(str_replace('_', ' ', $this->name));
    }

    public function url($url)
    {
        $this->url = $url;
        return $this;
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

    public function hasChildren()
    {
        return count($this->children) > 0;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getType()
    {
        return 'item';
    }

    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'label' => $this->getLabel(),
            'icon' => $this->getIcon(),
            'url' => $this->url,
        ];
    }
}