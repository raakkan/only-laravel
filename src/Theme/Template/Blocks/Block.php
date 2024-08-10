<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Blocks;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasBlockComponents;

abstract class Block extends BaseBlock 
{
    use HasBlockComponents;
    protected $children = [];

    public function children($children)
    {
        $this->children = $children;
        return $this;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'label' => $this->label ?? $this->name,
            'source' => $this->source,
            'group' => $this->group,
            'order' => $this->order,
            'type' => $this->type ?? 'block',
        ];
    }

    public function create($template, $parent = null)
    {
        $order = $this->order;
        if ($parent) {
            $childCount = $template->blocks()->where('parent_id', $parent->id)->count();
            $order = $childCount === 0 ? 0 : $childCount++;
        }

        $model = $template->blocks()->create([
            'name' => $this->name,
            'template_id' => $template->id,
            'source' => $this->getSource(),
            'order' => $order,
            'location' => $this->location,
            'type' => 'block',
            'parent_id' => $parent ? $parent->id : null
        ]);
        
        $this->setModel($model);
        $this->storeDefaultSettingsToDatabase();

        foreach ($this->components as $component) {
            $component->create($template, $model);
        }
    }
}