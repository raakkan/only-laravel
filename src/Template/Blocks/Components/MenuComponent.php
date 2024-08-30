<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Components;

use Raakkan\OnlyLaravel\Menu\Menu;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Raakkan\OnlyLaravel\Models\MenuModel;

class MenuComponent extends BlockComponent
{
    protected string $name = 'menu';
    protected $group = 'core';
    protected $source = 'raakkan/only-laravel';
    protected $view = 'only-laravel::template.components.menu';
    protected $selectedMenu = null;

    public function getBlockSettings()
    {
        return [
            Section::make('Menu Settings')->schema([
                Select::make('menu.menu')->label('Menu')->options(function(){
                    $menus = MenuModel::all();
                    return $menus->pluck('name', 'id')->toArray();
                })->default($this->selectedMenu ?? MenuModel::first()->id),
            ])->compact()
        ];
    }

    public function setBlockSettings($settings)
    {
        if (is_array($settings) && array_key_exists('menu', $settings)) {
            $this->selectedMenu = $settings['menu'];
        }
        return $this;
    }

    public function getMenu()
    {
        $menu = MenuModel::where('id', $this->selectedMenu)->with('items')->first();
        return Menu::make($this->name)->setCachedModel($menu);
    }
}