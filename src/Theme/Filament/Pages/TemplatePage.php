<?php

namespace Raakkan\OnlyLaravel\Theme\Filament\Pages;

use Filament\Pages\Page;
use Raakkan\OnlyLaravel\Theme\Template\Blocks\FooterBlock;
use Raakkan\OnlyLaravel\Theme\Template\Blocks\Items\ImageBlockItem;
use Raakkan\OnlyLaravel\Theme\Template\Template;
use Raakkan\OnlyLaravel\Theme\Template\Blocks\HeaderBlock;

class TemplatePage extends Page
{
    protected static string $view = 'only-laravel::theme.filament.pages.template-page';

    protected static ?string $navigationGroup = 'Appearance';
    protected static ?string $slug = 'appearance/templates';

    public function getTemplate()
    {
        return Template::make('home')->blocks([
            HeaderBlock::make()->items([
                ImageBlockItem::make(),
            ]),
            FooterBlock::make(),
        ]);
    }

    public function getTitle(): string
    {
        return 'Templates';
    }

    public static function getNavigationLabel(): string
    {
        return 'Templates';
    }
}