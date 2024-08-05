<?php

namespace Raakkan\OnlyLaravel\Theme\Template;

use Illuminate\Contracts\Support\Arrayable;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;
use Raakkan\OnlyLaravel\Theme\Concerns\HasSource;
use Raakkan\OnlyLaravel\Support\Concerns\HasLabel;
use Raakkan\OnlyLaravel\Theme\Models\ThemeTemplate;
use Raakkan\OnlyLaravel\Theme\Template\Blocks\Block;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasBlocks;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\HasSettings;

class Template implements Arrayable
{
    use Makable;
    use HasName;
    use HasLabel;
    use HasBlocks;
    use HasSettings;
    use HasSource;
    protected $for;
    protected $useAllThemes = false;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function for($for)
    {
        $this->for = $for;
        return $this;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'label' => $this->label ?? $this->name,
            'source' => $this->source,
            'for' => $this->for,
            'settings' => $this->settings,
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
            'source' => $this->source,
            'for' => $this->for,
        ]);

        foreach ($this->blocks as $block) {
            $block->create($template);
        }
    }
}