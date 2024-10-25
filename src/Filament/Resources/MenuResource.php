<?php

namespace Raakkan\OnlyLaravel\Filament\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Raakkan\OnlyLaravel\Facades\MenuManager;
use Raakkan\OnlyLaravel\Filament\Pages\EditMenuPage;
use Raakkan\OnlyLaravel\Filament\Pages\ListMenuPage;
use Raakkan\OnlyLaravel\Models\MenuModel;

class MenuResource extends Resource
{
    protected static ?string $model = MenuModel::class;

    protected static ?string $navigationGroup = 'Appearance';

    protected static ?string $slug = 'appearance/menus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->label('Name')->unique(),
                Select::make('location')->required()->label('Location')->options(MenuManager::getMenuLocationsArray()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('location')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => ListMenuPage::route('/'),
            'edit' => EditMenuPage::route('/{record}/edit'),
        ];
    }

    public function getTitle(): string
    {
        return 'Menus';
    }

    public static function getNavigationLabel(): string
    {
        return 'Menus';
    }

    public static function getModelLabel(): string
    {
        return 'Menu';
    }
}
