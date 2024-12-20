<?php

namespace Raakkan\OnlyLaravel\Template\Blocks;

use Illuminate\Support\Facades\Log;
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
            $order = $childCount === 0 ? 0 : $childCount;
        } else {
            $childCount = $template->blocks()->whereNull('parent_id')->count();
            $order = $childCount === 0 ? 0 : $childCount;
        }

        $model = $template->blocks()->create([
            'name' => $this->name,
            'template_id' => $template->id,
            'order' => $order,
            'location' => $this->location,
            'type' => 'block',
            'parent_id' => $parent ? $parent->id : null,
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
            'block' => $this,
        ]);
    }

    public function render()
    {
        if (! view()->exists($this->view)) {
            if (app()->environment('local')) {
                throw new \Exception("View '{$this->view}' does not exist.");
            } else {
                Log::error("View '{$this->view}' does not exist.");

                return '';
            }
        }

        return view($this->view, [
            'block' => $this,
        ]);
    }
}
