<?php

namespace Raakkan\OnlyLaravel\Theme\Models;

use Illuminate\Database\Eloquent\Model;
use Raakkan\OnlyLaravel\Theme\Menu\Menu;

class ThemeMenu extends Model
{
    protected $fillable = ['name', 'location','is_active', 'source'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(ThemeMenuItem::class, 'menu_id')->orderBy('order', 'asc');
    }

    public static function getMenu($menu_name)
    {
        return Menu::makeByModel(self::where('name', $menu_name)->first());
    }

    public function getTable(): string
    {
        return config('only-laravel::themes.menus.database_table_name', 'theme_menus');
    }
}