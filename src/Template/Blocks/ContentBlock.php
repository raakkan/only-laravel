<?php

namespace Raakkan\OnlyLaravel\Template\Blocks;

use Raakkan\OnlyLaravel\Facades\Theme;
use Raakkan\OnlyLaravel\Admin\Forms\Components\Select;
use Raakkan\OnlyLaravel\Admin\Forms\Components\Toggle;
use Raakkan\OnlyLaravel\Template\Enums\ContentSidebar;
use Raakkan\OnlyLaravel\Template\Blocks\Components\BlockComponent;

class ContentBlock extends Block
{
    protected string $name = 'content-block';
    protected string $label = 'Content Block';

    protected $group = 'core';

    protected $source = 'raakkan/only-laravel';

    protected $deletable = false;

    protected $sortable = false;

    protected $disableable = false;

    protected $addable = false;

    public $sidebar = true;

    public $sidebarPosition = ContentSidebar::RIGHT;

    protected $view = 'only-laravel::template.blocks.content';

    public function sideBar($sideBar = true, $position = ContentSidebar::LEFT)
    {
        $this->sidebar = $sideBar;
        $this->sidebarPosition = $position;

        return $this;
    }

    /**
     * @doc Add blocks to the left sidebar of the content block. Important: call this method after adding blocks to the content block.
     */
    public function leftSideBar($blocks = [])
    {
        $sidebarBlocks = collect($blocks)->filter(function ($item) {
            return $item instanceof BaseBlock || $item instanceof BlockComponent;
        })->each(function ($block) {
            $block->setLocation('left-sidebar');
        })->all();

        $this->children = array_merge($this->children, $sidebarBlocks);

        return $this->sideBar(true, ContentSidebar::LEFT);
    }

    /**
     * @doc Add blocks to the right sidebar of the content block. Important: call this method after adding blocks to the content block.
     */
    public function rightSideBar($blocks = [])
    {
        $sidebarBlocks = collect($blocks)->filter(function ($item) {
            return $item instanceof BaseBlock || $item instanceof BlockComponent;
        })->each(function ($block) {
            $block->setLocation('right-sidebar');
        })->all();

        $this->children = array_merge($this->children, $sidebarBlocks);

        return $this->sideBar(true, ContentSidebar::RIGHT);
    }

    public function sidebarBothSides()
    {
        return $this->sideBar(true, ContentSidebar::BOTH);
    }

    public function isSideBarEnabled()
    {
        return $this->sidebar;
    }

    public function getSideBarPosition()
    {
        return $this->sidebarPosition;
    }

    public function getBlockSettings()
    {
        return [
            Toggle::make('sidebar.enabled')->label('Sidebar Enabled')->default(true),
            Select::make('sidebar.position')->label('Sidebar Position')->default($this->getSideBarPosition()->value)->options([
                [
                    'id' => ContentSidebar::LEFT->value,
                    'name' => ContentSidebar::LEFT->name
                ],
                [
                    'id' => ContentSidebar::RIGHT->value, 
                    'name' => ContentSidebar::RIGHT->name
                ],
                [
                    'id' => ContentSidebar::BOTH->value,
                    'name' => ContentSidebar::BOTH->name
                ]
            ]),
        ];
    }

    public function setBlockSettings($settings)
    {
        if (is_array($settings) && array_key_exists('sidebar', $settings)) {
            $this->sidebar = $settings['sidebar']['enabled'];
            $this->sidebarPosition = $this->getSidebarEnum($settings['sidebar']['position']);
        }
    }

    public function getSidebarEnum($position)
    {
        return ContentSidebar::from($position);
    }

    public function editorRender()
    {
        return view('only-laravel::template.editor.content', [
            'block' => $this,
        ]);
    }

    public function render()
    {
        if (Theme::hasView('core.blocks.content')) {
            return view(Theme::getThemeView('core.blocks.content'), ['block' => $this]);
        }

        return view('only-laravel::template.blocks.content', ['block' => $this]);
    }

    public function getViewPaths()
    {
        if (Theme::hasView('core.blocks.content')) {
            return [Theme::getViewPath('core.blocks.content')];
        }
        return [
            __DIR__.'/../../../resources/views/template/blocks/content.blade.php',
        ];
    }
}
