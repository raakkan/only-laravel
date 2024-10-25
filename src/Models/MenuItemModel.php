<?php

namespace Raakkan\OnlyLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Translatable\HasTranslations;

class MenuItemModel extends Model
{
    use HasTranslations;

    public $translatable = ['label'];

    protected $fillable = ['menu_id', 'name', 'target', 'order', 'url', 'icon', 'parent_id', 'label'];

    public function menu()
    {
        return $this->belongsTo(MenuModel::class);
    }

    public function parent()
    {
        return $this->belongsTo(MenuItemModel::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItemModel::class, 'parent_id')->orderBy('order', 'asc');
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

    public function getTable(): string
    {
        return 'menu_items';
    }
}
