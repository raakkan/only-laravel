<?php

namespace Raakkan\OnlyLaravel\Menu;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use Raakkan\OnlyLaravel\Menu\Concerns\HasMenuItemChildren;
use Raakkan\OnlyLaravel\Menu\Concerns\HasUrl;
use Raakkan\OnlyLaravel\Support\Concerns\HasGroup;
use Raakkan\OnlyLaravel\Support\Concerns\HasIcon;
use Raakkan\OnlyLaravel\Support\Concerns\HasLabel;
use Raakkan\OnlyLaravel\Support\Concerns\HasModel;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\HasSettings;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;
use Raakkan\OnlyLaravel\Template\Concerns\HasOrder;

class MenuItem implements Arrayable
{
    use HasGroup;
    use HasIcon;
    use HasLabel { getLabel as protected; }
    use HasMenuItemChildren;
    use HasModel;
    use HasName;
    use HasOrder;
    use HasSettings;
    use HasUrl;
    use Makable;

    protected $model;

    protected $parent;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getLabel()
    {
        return $this->label ?? Str::headline(str_replace('_', ' ', $this->name));
    }

    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'label' => $this->getLabel(),
            'icon' => $this->getIcon(),
            'url' => $this->url,
            'group' => $this->getGroup(),
        ];
    }

    public function create($menu, $parent = null)
    {
        $order = $this->order;
        if ($parent) {
            $childCount = $menu->items()->where('parent_id', $parent->id)->count();
            $order = $childCount === 0 ? 0 : $childCount++;
        }

        $model = $menu->items()->create([
            'name' => $this->name,
            'menu_id' => $menu->id,
            'order' => $order,
            'url' => $this->url,
            'icon' => $this->icon,
            'label' => $this->getLabel(),
            'target' => '_self',
            'parent_id' => $parent ? $parent->id : null,
        ]);

        $this->setModel($model);
        $this->storeDefaultSettingsToDatabase();

        foreach ($this->children as $child) {
            $child->create($menu, $model);
        }
    }
}
