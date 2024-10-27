<?php

namespace Raakkan\OnlyLaravel\Theme\Concerns;

use Illuminate\Support\Facades\File;
use Illuminate\Contracts\View\View;

trait HandlesThemeViews
{
    public function registerActiveThemeViews(): void
    {
        $activeTheme = $this->getActiveTheme();
        
        if (!$activeTheme) {
            return;
        }

        $themePath = $this->getThemePath($activeTheme->name);
        
        if (!$themePath) {
            return;
        }

        $viewsPath = $themePath . '/views';
        if (File::exists($viewsPath)) {
            view()->addNamespace('theme', $viewsPath);
            
            // Debug view namespaces
            // dd(
            //     [
            //         'namespaces' => view()->getFinder()->getHints(),
            //         'view_exists' => view()->exists("theme::livewire.tools.widgets.category"),
            //         'views_path' => $viewsPath,
            //     ]
            // );
        }
    }

    public function render(string $view, array $data = [], array $mergeData = []): View
    {
        if (!$this->getActiveTheme()) {
            throw new \RuntimeException('No active theme found');
        }

        return view("theme::{$view}", $data, $mergeData);
    }

    public function hasView(string $view): bool
    {
        return view()->exists("theme::{$view}");
    }

    public function getThemeView(string $view): string
    {
        return "theme::{$view}";
    }

    public function getViewPath(string $view): string
    {
        $viewPath = str_replace('.', '/', $view);
        
        return $this->getThemePath($this->getActiveTheme()->name) . "/views/{$viewPath}.blade.php";
    }
}
