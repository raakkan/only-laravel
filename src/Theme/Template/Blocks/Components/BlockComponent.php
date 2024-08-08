<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Blocks\Components;

use Raakkan\OnlyLaravel\Theme\Template\Blocks\BaseBlock;

abstract class BlockComponent extends BaseBlock
{
    public function toArray()
    {
        return [
            'name' => $this->name,
            'type' => $this->type ?? 'component',
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
}