<?php

namespace Raakkan\OnlyLaravel\Setting\Filament\Pages;

use Closure;
use Filament\Forms\Components\Textarea;
use Raakkan\OnlyLaravel\Setting\BaseSettingPage;

class GlobalPageInsertPage extends BaseSettingPage
{
    protected static ?string $slug = 'settings/global-page-insert';

    public function schema(): array|Closure
    {
        return [
            Textarea::make('onlylaravel.global_insert.header_script')
                ->label('Header Script')
                ->helperText('Custom script or style to be inserted in the <head> tag')
                ->rows(5),

            Textarea::make('onlylaravel.global_insert.body_script')
                ->label('Body Script')
                ->helperText('Custom script to be inserted at the beginning of the <body> tag')
                ->rows(5),

            Textarea::make('onlylaravel.global_insert.footer_script')
                ->label('Footer Script')
                ->helperText('Custom script to be inserted at the end of the <body> tag')
                ->rows(5),
        ];
    }

    public function getTitle(): string
    {
        return 'Global Page Insert';
    }

    public static function getNavigationLabel(): string
    {
        return 'Global Page Insert';
    }
}