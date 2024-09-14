<?php

namespace Raakkan\OnlyLaravel\Setting\Filament\Pages;

use Closure;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Raakkan\OnlyLaravel\Models\TemplateModel;
use Raakkan\OnlyLaravel\Setting\BaseSettingPage;

class AiSettingsPage extends BaseSettingPage
{
    protected static ?string $slug = 'settings/ai';

    public function schema(): array|Closure
    {
        return [
            TextInput::make('onlylaravel.ai.openai_api_key')
                ->label('OpenAI API Key')
                ->required()
                ->dehydrateStateUsing(fn ($state) => encrypt($state))
                ->dehydrated(function ($state) {
                    return isset($state);
                })
                ->afterStateHydrated(function (TextInput $component, $state) {
                    $component->state($state ? decrypt($state) : null);
                }),
        ];
    }

    public function getTitle(): string
    {
        return 'AI Settings';
    }

    public static function getNavigationLabel(): string
    {
        return 'AI';
    }
}