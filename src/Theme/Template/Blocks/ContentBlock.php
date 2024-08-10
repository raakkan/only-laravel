<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Blocks;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Raakkan\OnlyLaravel\Theme\Enums\ContentSidebar;

class ContentBlock extends Block
{
    protected string $name = 'content';
    protected $group = 'core';
    protected $source = 'raakkan/only-laravel';
    protected $deletable = false;
    protected $sortable = false;
    protected $backgroundSettings = true;

    public $sidebar = true;
    public $sidebarPosition = ContentSidebar::LEFT;
    protected $view = 'only-laravel::templates.blocks.content';

    public function sideBar($sideBar = true, $position = ContentSidebar::LEFT)
    {
        $this->sidebar = $sideBar;
        $this->sidebarPosition = $position;
        return $this;
    }

    public function leftSideBar()
    {
        return $this->sideBar(true, ContentSidebar::LEFT);
    }

    public function rightSideBar()
    {
        return $this->sideBar(true, ContentSidebar::RIGHT);
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
            Section::make('Sidebar')->schema([
                Toggle::make('sidebar.enabled')->label('Enabled')->default(true),
                Select::make('sidebar.position')->label('Position')->default($this->getSideBarPosition())->options([
                    ContentSidebar::LEFT->value => ContentSidebar::LEFT->name,
                    ContentSidebar::RIGHT->value => ContentSidebar::RIGHT->name,
                ]),
            ])->compact()
        ];
    }

    public function setBlockSettings($settings)
    {
        if(array_key_exists('sidebar', $settings)) {
            $this->sidebar = $settings['sidebar']['enabled'];
            $this->sidebarPosition = $settings['sidebar']['position'];
        }
    }
}
