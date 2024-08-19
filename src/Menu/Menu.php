<?php

namespace Raakkan\OnlyLaravel\Menu;

use Raakkan\OnlyLaravel\Models\MenuModel;
use Illuminate\Contracts\Support\Arrayable;
use Raakkan\OnlyLaravel\Theme\Menu\MenuItem;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;
use Raakkan\OnlyLaravel\Support\Concerns\HasModel;
use Raakkan\OnlyLaravel\Menu\Concerns\HasMenuItems;
use Raakkan\OnlyLaravel\Support\Concerns\HasSettings;
use Raakkan\OnlyLaravel\Menu\Concerns\HasMenuLocation;
use Raakkan\OnlyLaravel\Template\Concerns\Disableable;

class Menu implements Arrayable
{
    use Makable;
    use HasName;
    use HasMenuItems;
    use HasMenuLocation;
    use HasSettings;
    use HasModel;
    use Disableable;

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
}