<?php

namespace Raakkan\OnlyLaravel\Theme;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Raakkan\OnlyLaravel\Theme\Concerns\HandlesThemeViews;
use Raakkan\OnlyLaravel\Theme\Models\ThemeModel;

class ThemeManager
{
    use HandlesThemeViews;

    protected Collection $themes;

    protected ?ThemeModel $activeTheme = null;

    protected string $themesPath;

    protected ?ThemeJson $activeThemeJson = null;

    public function __construct()
    {
        $this->themesPath = base_path('themes');
        $this->themes = new Collection;
        $this->loadThemes();
    }

    public function loadThemes(): void
    {
        if (! File::exists($this->themesPath)) {
            File::makeDirectory($this->themesPath, 0755, true);
        }

        $themeFolders = File::directories($this->themesPath);

        foreach ($themeFolders as $themeFolder) {
            $themeJsonPath = $themeFolder.'/theme.json';
            $themeJson = new ThemeJson($themeJsonPath);

            if ($themeJson->isValid()) {
                $this->themes->put($themeJson->getName(), [
                    'path' => $themeFolder,
                    'json' => $themeJson,
                    'config' => $themeJson->toArray(),
                ]);
            }
        }
    }

    public function updateOrCreateThemes(): void
    {
        $this->themes->each(function ($theme) {
            $existingTheme = ThemeModel::where('name', $theme['json']->getName())->first();

            if ($existingTheme) {
                $jsonVersion = $theme['config']['version'] ?? '0.0.0';
                $dbVersion = $existingTheme->version ?? '0.0.0';

                if (version_compare($jsonVersion, $dbVersion, '>')) {
                    $existingTheme->update(['update_available' => true]);
                }
            } else {
                ThemeModel::create($theme['config']);
            }
        });
    }

    public function getAllThemes(): Collection
    {
        return ThemeModel::all();
    }

    public function getTheme(string $name): ?ThemeModel
    {
        return ThemeModel::where('name', $name)->first();
    }

    public function getActiveTheme(): ?ThemeModel
    {
        if (! $this->activeTheme) {
            $this->activeTheme = ThemeModel::activatedTheme();
        }

        return $this->activeTheme;
    }

    public function getActiveThemeJson(): ?ThemeJson
    {
        if (! $this->activeTheme) {
            return null;
        }

        if (! $this->activeThemeJson) {
            $themePath = $this->getThemePath($this->activeTheme->name);
            if ($themePath) {
                $themeJsonPath = $themePath.'/theme.json';
                $this->activeThemeJson = new ThemeJson($themeJsonPath);
            }
        }

        return $this->activeThemeJson;
    }

    public function activateTheme(string $name): bool
    {
        $theme = $this->getTheme($name);

        if (! $theme) {
            return false;
        }

        $activated = $theme->activate();

        if ($activated) {
            $this->activeTheme = $theme;
            $this->activeThemeJson = null;
            $this->registerActiveThemeViews();
        }

        return $activated;
    }

    public function updateTheme(string $name): bool
    {
        $theme = $this->getTheme($name);
        if (! $theme) {
            return false;
        }

        return $theme->updateTheme();
    }

    public function themeExists(string $name): bool
    {
        return ThemeModel::where('name', $name)->exists();
    }

    public function getThemePath(string $name): ?string
    {
        return $this->themes->get($name)['path'] ?? null;
    }
}
