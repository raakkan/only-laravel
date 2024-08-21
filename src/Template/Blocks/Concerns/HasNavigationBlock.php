<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Concerns;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Raakkan\OnlyLaravel\Template\Blocks\Components\BlockComponent;

trait HasNavigationBlock
{
    protected $showStartComponent = true;
    protected $showCenterComponent = true;
    protected $showEndComponent = true;
    public $justifyContent = 'space-between';

    public function startComponent(BlockComponent $component)
    {
        $this->childrens = array_merge($this->children, [$component->setLocation('navigation-start')]);
        $this->showStartComponent = true;
        return $this;
    }

    public function centerComponent(BlockComponent $component)
    {
        $this->childrens = array_merge($this->children, [$component->setLocation('navigation-center')]);
        $this->showCenterComponent = true;
        return $this;
    }

    public function endComponent(BlockComponent $component)
    {
        $this->childrens = array_merge($this->children, [$component->setLocation('navigation-end')]);
        $this->showEndComponent = true;
        return $this;
    }

    public function disableStartComponent()
    {
        $this->showStartComponent = false;

        return $this;
    }

    public function disableCenterComponent()
    {
        $this->showCenterComponent = false;
        return $this;
    }

    public function disableEndComponent()
    {
        $this->showEndComponent = false;
        return $this;
    }

    public function showStartComponent()
    {
        return $this->showStartComponent;
    }

    public function showCenterComponent()
    {
        return $this->showCenterComponent;
    }

    public function showEndComponent()
    {
        return $this->showEndComponent;
    }

    public function getBlockCustomSettings()
    {
        return [
            Section::make('Navigation')->schema([
                Toggle::make('navigation.start_component')->label('Show Start Component')->default($this->showStartComponent()),
                Toggle::make('navigation.center_component')->label('Show Center Component')->default($this->showCenterComponent()),
                Toggle::make('navigation.end_component')->label('Show End Component')->default($this->showEndComponent()),
                Select::make('navigation.content_justify')->label('Content Justify')->options([
                    'flex-start' => 'Start',
                    'center' => 'Center',
                    'flex-end' => 'End',
                    'space-between' => 'Space Between',
                    'space-around' => 'Space Around',
                    'space-evenly' => 'Space Evenly',
                ])->default($this->justifyContent),
            ])->compact()
        ];
    }

    public function setBlockCustomSettings($settings)
    {
        if (is_array($settings) && array_key_exists('navigation', $settings)) {
            if (array_key_exists('start_component', $settings['navigation'])) {
                $this->showStartComponent = $settings['navigation']['start_component'];
            }
            if (array_key_exists('center_component', $settings['navigation'])) {
                $this->showCenterComponent = $settings['navigation']['center_component'];
            }
            if (array_key_exists('end_component', $settings['navigation'])) {
                $this->showEndComponent = $settings['navigation']['end_component'];
            }
            if (array_key_exists('content_justify', $settings['navigation'])) {
                $this->justifyContent = $settings['navigation']['content_justify'];
            }
        }
        return $this;
    }
}