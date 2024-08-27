<?php

namespace Raakkan\OnlyLaravel\Template;

use Illuminate\Contracts\Support\Arrayable;
use Raakkan\OnlyLaravel\Models\TemplateModel;
use Raakkan\OnlyLaravel\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasHeightSettings;

class PageTemplate extends BaseTemplate
{
    use HasHeightSettings;
    protected $type = 'template';
    protected $customCssFilesSettings = true;
    protected $customJsFilesSettings = true;
    protected $customScript = true;
    protected $coreFileSettings = true;
    protected $includeCoreFiles = true;

    public function __construct($name)
    {
        $this->name = $name;
        $this->paddingLeftSettings = true;
        $this->paddingLeftResponsiveSettings = true;
        $this->paddingRightSettings = true;
        $this->paddingRightResponsiveSettings = true;
        $this->maxwidthResponsiveSettings = true;
        $this->heightResponsiveSettings = true;
    }

    public function create()
    {
        $this->storeDefaultSettingsToDatabase();
        if (TemplateModel::where('name', $this->name)->exists()) {
            return;
        }

        $template = TemplateModel::create([
            'name' => $this->name,
            'label' => $this->label ?? $this->name,
            'source' => $this->getSource(),
            'for' => $this->forPage,
        ]);

        $this->setModel($template, false);
        $this->storeDefaultSettingsToDatabase();

        foreach ($this->blocks as $block) {
            $block->create($template);
        }
    }

    public function render()
    {
        return view('only-laravel::template.template', [
            'template' => $this
        ]);
    }
}