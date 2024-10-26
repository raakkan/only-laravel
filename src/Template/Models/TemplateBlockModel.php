<?php

namespace Raakkan\OnlyLaravel\Template\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Raakkan\OnlyLaravel\Template\PageTemplate;

class TemplateBlockModel extends Model
{
    protected $fillable = ['name', 'order', 'settings', 'template_id', 'parent_id', 'location', 'type', 'disabled'];

    protected $casts = [
        'settings' => 'array',
        'disabled' => 'boolean',
    ];

    public function template()
    {
        return $this->belongsTo(TemplateModel::class, 'template_id');
    }

    public function parent()
    {
        return $this->belongsTo(TemplateBlockModel::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(TemplateBlockModel::class, 'parent_id')->orderBy('order', 'asc');
    }

    public function updateOrder($newPosition)
    {
        $oldPosition = $this->order;
        $parentId = $this->parent_id;
        $location = $this->location;
        $templateId = $this->template_id;

        DB::transaction(function () use ($newPosition, $oldPosition, $parentId, $location, $templateId) {

            DB::table($this->getTable())
                ->where('id', $this->id)
                ->update(['order' => 99999999]);

            if ($oldPosition < $newPosition) {
                DB::table($this->getTable())
                    ->where('template_id', $templateId)
                    ->where('parent_id', $parentId)
                    ->where('location', $location)
                    ->where('order', '>', $oldPosition)
                    ->where('order', '<=', $newPosition)
                    ->decrement('order');
            } else {
                DB::table($this->getTable())
                    ->where('template_id', $templateId)
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

    public function getPageTemplate()
    {
        $template = PageTemplate::make($this->template->name);
        $template->initializeFromCachedModel($this->template);

        return $template;
    }

    public function getTable(): string
    {
        return 'template_blocks';
    }
}
