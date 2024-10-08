<?php

namespace Raakkan\OnlyLaravel\Template\Blocks;

use Raakkan\OnlyLaravel\Template\Concerns\HasChildren;

abstract class Block extends BaseBlock 
{
    use HasChildren;
    protected $type = 'block';

    public function toArray()
    {
        return [
            'name' => $this->name,
            'label' => $this->label ?? $this->name,
            'source' => $this->source,
            'group' => $this->group,
            'order' => $this->order,
            'type' => $this->type,
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
        
        foreach ($this->children as $child) {
            
            $child->create($template, $model);
        }
    }

    public function editorRender()
    {
        return view('only-laravel::template.editor.block', [
            'block' => $this
        ]);
    }

    public function render()
    {
        return view($this->view, [
            'block' => $this
        ]);
    }
}