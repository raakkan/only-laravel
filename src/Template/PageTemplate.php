<?php

namespace Raakkan\OnlyLaravel\Template;

use Raakkan\OnlyLaravel\Models\TemplateModel;

class PageTemplate extends BaseTemplate
{
    protected $type = 'template';
    protected $customCssFilesSettings = true;
    protected $customJsFilesSettings = true;
    protected $customScript = true;
    protected $coreFileSettings = true;

    public function __construct($name)
    {
        $this->name = $name;
        $this->enablePaddingSettingOnly(['paddingLeftResponsiveSettings', 'paddingRightResponsiveSettings']);
        $this->enableWidthSettingOnly(['maxWidthResponsiveSettings']);
        $this->widthSettingsTabColumn = 1;
    }

    public function create()
    {
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