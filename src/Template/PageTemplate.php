<?php

namespace Raakkan\OnlyLaravel\Template;

use Raakkan\OnlyLaravel\Models\TemplateModel;
use Raakkan\OnlyLaravel\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Template\Models\DummyPageModel;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasCustomStyleSettings;

class PageTemplate extends BaseTemplate
{
    use HasCustomStyleSettings;
    protected $type = 'template';

    public function __construct($name)
    {
        $this->name = $name;
        $this->enablePaddingSettingOnly(['paddingLeftResponsiveSettings', 'paddingRightResponsiveSettings']);
        $this->enableWidthSettingOnly(['maxWidthResponsiveSettings']);
        $this->widthSettingsTabColumn = 1;
        $this->enableCustomStyleSettingOnly(['customStyleSettings', 'customCssSettings', 'customScript']);
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

    public function getDummyPageModel()
    {
        $dummyPageModel = TemplateManager::getDummyPageModel($this->getName());
        
        if ($dummyPageModel) {
            return $dummyPageModel;
        } else {
            return DummyPageModel::make($this->getName());
        }
    }

    public function render()
    {
        return view('only-laravel::template.template', [
            'template' => $this
        ]);
    }
}