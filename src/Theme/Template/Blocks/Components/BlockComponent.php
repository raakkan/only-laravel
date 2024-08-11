<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Blocks\Components;

use Raakkan\OnlyLaravel\Theme\Template\Blocks\BaseBlock;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasDesignVariant;

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
        return view('only-laravel::templates.editor.component', [
            'block' => $this
        ]);
    }

    public function render()
    {
        foreach ($this->getDesignVariants() as $key => $value) {
            if($key === $this->getDesignVariant() && view()->exists($value['view'])) {
                $this->view = $value['view'];
                break;
            }
        }

        return view($this->view, [
            'block' => $this
        ]);
    }
}