<?php

namespace Raakkan\OnlyLaravel\Theme\Template;

use Illuminate\Contracts\Support\Arrayable;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;
use Raakkan\OnlyLaravel\Theme\Concerns\HasSource;
use Raakkan\OnlyLaravel\Support\Concerns\HasLabel;
use Raakkan\OnlyLaravel\Theme\Models\ThemeTemplate;
use Raakkan\OnlyLaravel\Theme\Facades\ThemesManager;
use Raakkan\OnlyLaravel\Theme\Template\Blocks\Block;
use Raakkan\OnlyLaravel\Theme\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasBlocks;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasForPage;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasForTheme;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasSettings;

class Template implements Arrayable
{
    use Makable;
    use HasName;
    use HasLabel;
    use HasBlocks;
    use HasSettings;
    use HasSource;
    use HasForPage;
    use HasForTheme;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function setModelData(ThemeTemplate $themeTemplate)
    {
        $this->name = $themeTemplate->name;
        $this->source = $themeTemplate->source;
        $this->forTheme = $themeTemplate->for_theme;
        $this->forPage = $themeTemplate->for_page;
        
        $blocks = [];
        foreach ($themeTemplate->blocks()->with('children')->where('parent_id', null)->where('disabled', 0)->get() as $block) {
            $themeBlock = TemplateManager::getBlockByName($block->name);
            
            $blocks[] = $themeBlock->setModel($block);
        }
        
        $this->blocks = $blocks;
        return $this;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'label' => $this->label ?? $this->name,
            'source' => $this->source,
            'forTheme' => $this->forTheme,
            'forPage' => $this->forPage,
            'blocks' => $this->blocks,
        ];
    }

    public function create()
    {
        if (ThemeTemplate::where('name', $this->name)->exists()) {
            return;
        }

        $template = ThemeTemplate::create([
            'name' => $this->name,
            'source' => $this->getSource(),
            'for_theme' => $this->forTheme,
            'for_page' => $this->forPage,
        ]);

        foreach ($this->blocks as $block) {
            $block->create($template);
        }
    }

    public function getActiveTheme()
    {
        return ThemesManager::current();
    }

    public function render()
    {
        return view('only-laravel::templates.template', [
            'template' => $this
        ]);
    }
}