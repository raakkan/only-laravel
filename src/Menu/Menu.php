<?php

namespace Raakkan\OnlyLaravel\Menu;

use Illuminate\Contracts\Support\Arrayable;
use Raakkan\OnlyLaravel\Menu\Concerns\HasMenuItems;
use Raakkan\OnlyLaravel\Menu\Concerns\HasMenuLocation;
use Raakkan\OnlyLaravel\Models\MenuModel;
use Raakkan\OnlyLaravel\Support\Concerns\HasModel;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\HasSettings;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;
use Raakkan\OnlyLaravel\Template\Concerns\Disableable;

class Menu implements Arrayable
{
    use Disableable;
    use HasMenuItems;
    use HasMenuLocation;
    use HasModel;
    use HasName;
    use HasSettings;
    use Makable;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'items' => $this->items,
        ];
    }

    public function allRequiredFieldsFilled()
    {
        return isset($this->name) && isset($this->location) && isset($this->location);
    }

    public function create()
    {
        if (MenuModel::where('name', $this->name)->exists()) {
            return;
        }

        $menu = MenuModel::create([
            'name' => $this->name,
            'location' => $this->location,
        ]);

        $this->setModel($menu);
        $this->storeDefaultSettingsToDatabase();

        foreach ($this->items as $item) {
            $item->create($menu);
        }
    }

    public function setCachedModel($model)
    {
        $menuItems = collect($model->items)->filter(function ($item) {
            return $item->disabled == 0 && $item->parent_id == null;
        });

        $items = collect($model->items)->filter(function ($item) {
            return $item->disabled == 0 && $item->parent_id;
        });

        $this->model = $model;

        // $this->setMenuSettings($this->model->settings);

        return $this->makeItems($menuItems, $items);
    }

    public function makeItems($menuItems, $items)
    {
        $builtItems = [];

        foreach ($menuItems as $menuItem) {
            $themeItem = $this->makeMenuItem($menuItem);
            $menuItemChildren = $items->where('parent_id', $menuItem->id)->sortBy('order');
            $themeItem = $this->buildItemTree($themeItem, $menuItemChildren, $items);
            $builtItems[] = $themeItem;
        }

        $this->items = $builtItems;

        return $this;
    }

    private function buildItemTree($themeItem, $menuItemChildren, $items)
    {
        $childItems = [];

        foreach ($menuItemChildren as $item) {
            $itemInstance = $this->makeMenuItem($item);
            $itemChildren = $items->where('parent_id', $item->id)->sortBy('order');

            if ($itemChildren->isNotEmpty()) {
                $itemInstance = $this->buildItemTree($itemInstance, $itemChildren, $items);
            }

            $childItems[] = $itemInstance;
        }

        $themeItem->children($childItems);

        return $themeItem;
    }

    public function makeMenuItem($item)
    {
        return MenuItem::make($item->name)->setUrl($item->url)->setLabel($item->label)->setTarget($item->target)->setModel($item);
    }
}
