<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Components;

use Raakkan\OnlyLaravel\Template\Blocks\BaseBlock;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasDesignVariant;

abstract class BlockComponent extends BaseBlock
{
    use HasDesignVariant;
    protected $type = 'component';
    
    public function toArray()
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'group' => $this->group,
            'source' => $this->source,
        ];
    }

    public function create($template, $parent = null)
    {
        $childCount = $template->blocks()->where('parent_id', $parent ? $parent->id : null)->where('location', $this->location)->count();

        $model = $template->blocks()->create([
            'name' => $this->name,
            'template_id' => $template->id,
            'source' => $this->getSource(),
            'order' => $childCount === 0 ? 0 : $childCount++,
            'location' => $this->location,
            'type' => 'component',
            'parent_id' => $parent ? $parent->id : null
        ]);
        
        $this->setModel($model);
        $this->storeDefaultSettingsToDatabase();
    }

    public function editorRender()
    {
        return view('only-laravel::template.editor.component', [
            'block' => $this
        ]);
    }

    public function render()
    {
        $designVariantView = $this->getActiveDesignVariantView();
        
        
        if($designVariantView && view()->exists($designVariantView)) {
            $this->view = $designVariantView;
        }

        if (!view()->exists($this->view)) {
            if (app()->environment('local')) {
                throw new \Exception("View '{$this->view}' does not exist.");
            } else {
                \Log::error("View '{$this->view}' does not exist.");
                return '';
            }
        }

        return view($this->view, [
            'block' => $this
        ]);
    }
}