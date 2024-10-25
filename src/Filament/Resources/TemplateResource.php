<?php

namespace Raakkan\OnlyLaravel\Filament\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Raakkan\OnlyLaravel\Filament\Pages\EditTemplatePage;
use Raakkan\OnlyLaravel\Filament\Pages\ListTemplatePage;
use Raakkan\OnlyLaravel\Models\TemplateModel;

class TemplateResource extends Resource
{
    protected static ?string $model = TemplateModel::class;

    protected static ?string $navigationGroup = 'Appearance';

    protected static ?string $slug = 'appearance/templates';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('source')->searchable()->sortable(),
                TextColumn::make('for')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTemplatePage::route('/'),
            'edit' => EditTemplatePage::route('/{record}/edit'),
        ];
    }

    public function getTitle(): string
    {
        return 'Templates';
    }

    public static function getNavigationLabel(): string
    {
        return 'Templates';
    }

    public static function getModelLabel(): string
    {
        return 'Template';
    }
}
