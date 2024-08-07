<?php

namespace Raakkan\OnlyLaravel\Theme\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ThemeTemplateBlock extends Model
{
    protected $fillable = ['name', 'source', 'order', 'settings', 'template_id', 'parent_id', 'location', 'type'];

    protected $casts = [
        'settings' => 'array',
    ];

    public function template()
    {
        return $this->belongsTo(ThemeTemplate::class, 'template_id');
    }

    public function parent()
    {
        return $this->belongsTo(ThemeTemplateBlock::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ThemeTemplateBlock::class, 'parent_id')->orderBy('order', 'asc');
    }

    public function updateOrder($newPosition)
    {
        $oldPosition = $this->order;
        $parentId = $this->parent_id;
        $location = $this->location;

        DB::transaction(function () use ($newPosition, $oldPosition, $parentId, $location) {

            DB::table($this->getTable())
                ->where('id', $this->id)
                ->update(['order' => 99999999]);

            if ($oldPosition < $newPosition) {
                DB::table($this->getTable())
                    ->where('parent_id', $parentId)
                    ->where('location', $location)
                    ->where('order', '>', $oldPosition)
                    ->where('order', '<=', $newPosition)
                    ->decrement('order');
            } else {
                DB::table($this->getTable())
                    ->where('parent_id', $parentId)
                    ->where('location', $location)
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

    public static function reorderSiblings($template, $order, $parentId, $location)
    {
        $siblings = $template->blocks()->where('parent_id', $parentId)->where('location', $location)->where('order', '>=', $order)->get();
        foreach ($siblings as $sibling) {
            $sibling->order = $sibling->order - 1;
            $sibling->save();
        }
    }

    public function getTable(): string
    {
        return 'theme_template_blocks';
    }
}
