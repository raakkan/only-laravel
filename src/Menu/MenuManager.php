<?php

namespace Raakkan\OnlyLaravel\Menu;

use Raakkan\OnlyLaravel\Facades\PageManager;
use Raakkan\OnlyLaravel\Menu\Concerns\HandleMenuLocations;
use Raakkan\OnlyLaravel\Menu\Concerns\HandleMenus;

class MenuManager
{
    use HandleMenuLocations;
    use HandleMenus;

    protected $items = [];

    public function getItems()
    {
        return array_merge($this->getPageMenuItems(), $this->items);
    }

    public function getPageMenuItems()
    {
        $models = PageManager::getAllModels();

        $items = [];
        foreach ($models as $model) {
            $data = $model::get();
            foreach ($data as $item) {
                $items[] = MenuItem::make($item->name)
                    ->url($item->generateUrl())
                    ->label($item->title ?? $item->name)
                    ->group($item->getMenuGroup());
            }
        }

        return $items;
    }
}
