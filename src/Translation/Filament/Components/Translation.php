<?php

namespace Raakkan\OnlyLaravel\Translation\Filament\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Textarea;
use Raakkan\OnlyLaravel\Translation\Models\Language;

class Translation extends Field
{
    protected string $view = 'only-laravel::filament.components.translation';

    public array $lang = [];


    protected function setUp(): void
    {
        $lang = [];
        foreach (Language::getActiveLanguages() as $language){
            $lang[] = Textarea::make($language->locale)
                ->placeholder($language->name)->label($language->name);
        }
        $this->schema($lang);
    }
}
