<?php

namespace Raakkan\OnlyLaravel\Theme\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

// TODO: menu and menu item add and update rules pending
class ThemeMenuItem extends Model
{
    protected $fillable = ['menu_id', 'name', 'order', 'url', 'icon', 'parent_id', 'source'];

    public function menu()
    {
        return $this->belongsTo(ThemeMenu::class);
    }

    public function parent()
    {
        return $this->belongsTo(ThemeMenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ThemeMenuItem::class, 'parent_id')->orderBy('order', 'asc');
    }

    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }

    public function hasParent()
    {
        return $this->parent()->exists();
    }

    public function updateOrder($newPosition)
    {
        $oldPosition = $this->order;
        $parentId = $this->parent_id;

        DB::transaction(function () use ($newPosition, $oldPosition, $parentId) {

            DB::table($this->getTable())
                ->where('id', $this->id)
                ->update(['order' => 99999999]);

            if ($oldPosition < $newPosition) {
                DB::table($this->getTable())
                    ->where('parent_id', $parentId)
                    ->where('order', '>', $oldPosition)
                    ->where('order', '<=', $newPosition)
                    ->decrement('order');
            } else {
                DB::table($this->getTable())
                    ->where('parent_id', $parentId)
                    ->where('order', '>=', $newPosition)
                    ->where('order', '<', $oldPosition)
                    ->orderBy('order', 'desc')
                    ->increment('order');
            }

            DB::table($this->getTable())
                ->where('id', $this->id)
                ->update(['order' => $newPosition]);
        });
    }

    public static function reorderSiblings($menu, $order, $parentId = null)
    {
        $siblings = $menu->items()->where('parent_id', $parentId)->where('order', '>=', $order)->get();
        foreach ($siblings as $sibling) {
            $sibling->order = $sibling->order - 1;
            $sibling->save();
        }
    }

    public static function addMenuItem($menu, $item)
    {
        $lastItem = self::where('menu_id', $menu->id)
            ->whereNull('parent_id')
            ->orderBy('order', 'desc')
            ->first();

        $order = $lastItem ? $lastItem->order + 1 : 0;

        $newItem = new self([
            'name' => $item['name'],
            'url' => $item['url'],
            'icon' => $item['icon'],
            'source' => $item['source'],
            'order' => $order,
        ]);

        $menu->items()->save($newItem);
    }

    public static function addAsChild($menu, $item, $parentId)
    {
        $lastChild = self::where('parent_id', $parentId)
            ->orderBy('order', 'desc')
            ->first();

        $order = $lastChild ? $lastChild->order + 1 : 0;

        $menuItem = new self([
            'name' => $item['name'],
            'order' => $order,
            'url' => $item['url'],
            'icon' => $item['icon'],
            'parent_id' => $parentId,
            'source' => $item['source'],
        ]);

        $menu->items()->save($menuItem);
    }

    public function getTable(): string
    {
        return config('only-laravel::themes.menus.menu_items_database_table_name', 'theme_menu_items');
    }
}
