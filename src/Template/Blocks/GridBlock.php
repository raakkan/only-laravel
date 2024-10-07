<?php

namespace Raakkan\OnlyLaravel\Template\Blocks;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Raakkan\OnlyLaravel\Template\Blocks\Components\BlockComponent;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasBackgroundSettings;
use Raakkan\OnlyLaravel\Template\Enums\GridColumns;

class GridBlock extends Block
{
    use HasBackgroundSettings;

    protected string $name = 'grid';
    protected $group = 'core';
    protected $source = 'raakkan/only-laravel';
    protected $backgroundSettings = true;
    protected $view = 'only-laravel::template.blocks.grid';

    public GridColumns $columns = GridColumns::TWO;

    public function columns(GridColumns $columns = GridColumns::TWO): self
    {
        $this->columns = $columns;
        return $this;
    }

    public function getColumns(): GridColumns
    {
        return $this->columns;
    }

    public function getGridClasses(): string
    {
        return $this->columns->getGridClasses();
    }

    public function getBlockSettings(): array
    {
        return [
            Section::make('Grid')->schema([
                Select::make('grid.columns')
                    ->label('Columns')
                    ->default($this->getColumns()->value)
                    ->options(GridColumns::options())
                    ->reactive()
            ])->compact()
        ];
    }

    public function setBlockSettings($settings): void
    {
        if (isset($settings['grid']['columns'])) {
            $this->columns = GridColumns::from($settings['grid']['columns']);
        }
    }

    public function getGridEnum($columns)
    {
        return GridColumns::from($columns);
    }

    public function editorRender()
    {
        return view('only-laravel::template.editor.grid', [
            'block' => $this
        ]);
    }

    public function render()
    {
        return view('only-laravel::template.blocks.grid', [
            'block' => $this
        ]);
    }

    public function getViewPaths()
    {
        return [
            resource_path('views/vendor/only-laravel/template/blocks/grid.blade.php'),
            __DIR__ . '/../../../resources/views/template/blocks/grid.blade.php',
        ];
    }
}