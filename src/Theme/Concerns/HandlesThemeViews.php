<?php

namespace Raakkan\OnlyLaravel\Theme\Concerns;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait HandlesThemeViews
{
    public function registerActiveThemeViews(): void
    {
        $activeTheme = $this->getActiveTheme();

        if (! $activeTheme) {
            return;
        }

        $themePath = $this->getThemePath($activeTheme->name);

        if (! $themePath) {
            return;
        }

        $viewsPath = $themePath.'/views';
        if (File::exists($viewsPath)) {
            $viewFinder = view()->getFinder();

            $directories = collect(File::directories($viewsPath))
                ->filter(fn ($dir) => basename($dir) !== 'components')
                ->toArray();

            $directories[] = $viewsPath;

            $viewFinder->prependNamespace('theme', $directories);

            $componentsPath = $viewsPath.'/components';
            if (File::exists($componentsPath)) {
                Blade::anonymousComponentPath($componentsPath, 'theme');
            }
        }
    }

    public function render(string $view, array $data = [], array $mergeData = []): View
    {
        if (! $this->getActiveTheme()) {
            throw new \RuntimeException('No active theme found');
        }

        return view("theme::{$view}", $data, $mergeData);
    }

    public function hasView(string $view): bool
    {
        if (Str::startsWith($view, 'x-')) {
            return $this->hasComponent($view);
        }

        return view()->exists("theme::{$view}");
    }

    public function getThemeView(string $view): string
    {
        return "theme::{$view}";
    }

    public function getViewPath(string $view): string
    {
        if (Str::startsWith($view, 'x-')) {
            return $this->getComponentPath($view);
        }

        $viewPath = str_replace('.', '/', $view);

        return $this->getThemePath($this->getActiveTheme()->name)."/views/{$viewPath}.blade.php";
    }

    public function hasComponent(string $component): bool
    {
        $component = Str::startsWith($component, 'x-') ? Str::after($component, 'x-') : $component;
        $componentPath = $this->getComponentPath($component);

        return File::exists($componentPath);
    }

    public function getComponentPath(string $component): string
    {
        $component = Str::startsWith($component, 'x-') ? Str::after($component, 'x-') : $component;
        $componentPath = str_replace('.', '/', $component);

        return $this->getThemePath($this->getActiveTheme()->name)."/views/components/{$componentPath}.blade.php";
    }

    public function getViewPaths(string $view): array
    {
        $paths = [$this->getViewPath($view)];
        
        // Get the view content
        $viewContent = File::get($this->getViewPath($view));
        
        // Find all component references in the view, including those with theme:: prefix
        preg_match_all('/<x-(theme::)?([^>\s]+)/', $viewContent, $matches);
        
        if (isset($matches[2])) {
            foreach ($matches[2] as $component) {
                if ($this->hasComponent($component)) {
                    $paths[] = $this->getComponentPath($component);
                }
            }
        }
        
        return array_unique($paths);
    }
}
