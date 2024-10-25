<?php

namespace Raakkan\OnlyLaravel\UI\Components;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

final class UI
{
    public static function registerUiComponents()
    {

        Blade::component('BladeUI\Icons\Components\Icon', 'svg');
        Blade::component('mary-button', Button::class);
        Blade::component('mary-card', Card::class);
        Blade::component('mary-icon', Icon::class);
        Blade::component('mary-input', Input::class);
        Blade::component('mary-list-item', ListItem::class);
        Blade::component('mary-modal', Modal::class);
        Blade::component('mary-menu', Menu::class);
        Blade::component('mary-menu-item', MenuItem::class);
        Blade::component('mary-header', Header::class);
        Blade::component('mary-pagination', Pagination::class);

        $componentDirectory = __DIR__;
        $namespace = __NAMESPACE__;

        $finder = new Finder;
        $finder->files()->in($componentDirectory)->name('*.php');

        foreach ($finder as $file) {
            $className = $file->getBasename('.php');
            if ($className === 'UI') {
                continue;
            }

            $fullyQualifiedClassName = $namespace.'\\'.$className;
            $componentName = Str::kebab($className);

            Blade::component($componentName, $fullyQualifiedClassName);
        }
    }
}
