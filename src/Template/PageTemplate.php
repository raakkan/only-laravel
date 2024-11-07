<?php

namespace Raakkan\OnlyLaravel\Template;

use Raakkan\OnlyLaravel\Admin\Forms\Components\Textarea;
use Raakkan\OnlyLaravel\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Facades\Theme;
use Raakkan\OnlyLaravel\Template\Models\DummyPageModel;
use Raakkan\OnlyLaravel\Template\Models\TemplateModel;

class PageTemplate extends BaseTemplate
{
    protected $type = 'template';

    protected $containerCssClasses = '';

    protected $headerContent = '';

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function create()
    {
        if ($template = TemplateModel::where('name', $this->name)->first()) {
            return $template;
        }

        $parentTemplate = $this->parentTemplate;
        if ($parentTemplate && is_string($parentTemplate)) {
            $parentTemplate = TemplateModel::where('name', $this->parentTemplate)->first();
        }

        $template = TemplateModel::create([
            'name' => $this->name,
            'label' => $this->label ?? $this->name,
            'is_parent' => $this->isParent,
            'parent_block_access' => $this->parentBlocks ?? [],
            'parent_template_id' => $parentTemplate?->id,
        ]);

        $this->setModel($template, false);
        $this->storeDefaultSettingsToDatabase();

        foreach ($this->blocks as $block) {
            $block->create($template);
        }

        // $this->buildCss();

        return $template;
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
        if (Theme::hasView('core.template')) {
            return view(Theme::getThemeView('core.template'), [
                'template' => $this,
            ]);
        }
        
        return view('only-laravel::template.template', [
            'template' => $this,
        ]);
    }

    public function getBlockSettings()
    {
        return [
            Textarea::make('onlylaravel.header_content')->label('Header Content')->rows(4)->default($this->getHeaderContent()),
            Textarea::make('onlylaravel.container_css_classes')->label('Container CSS Classes')->rows(4)->default($this->getContainerCssClasses()),
        ];
    }

    public function setBlockSettings($settings)
    {
        if (is_array($settings) && array_key_exists('onlylaravel', $settings)) {
            $onlylaravel = $settings['onlylaravel'];
            if (array_key_exists('header_content', $onlylaravel)) {
                $this->headerContent($onlylaravel['header_content']);
            }
            if (array_key_exists('container_css_classes', $onlylaravel)) {
                $this->containerCssClasses($onlylaravel['container_css_classes']);
            }
        }
    }

    public function getHeaderContent()
    {
        return $this->headerContent;
    }

    public function headerContent($content)
    {
        if (is_string($content)) {
            $this->headerContent = $content;
        }

        return $this;
    }

    public function getContainerCssClasses()
    {
        return $this->containerCssClasses;
    }

    public function containerCssClasses($classes)
    {
        if (is_array($classes)) {
            $this->containerCssClasses = implode(' ', $classes);
        } elseif (is_string($classes)) {
            $this->containerCssClasses = $classes;
        }

        return $this;
    }
}
