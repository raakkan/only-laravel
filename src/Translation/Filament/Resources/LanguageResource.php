<?php

namespace Raakkan\OnlyLaravel\Translation\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Raakkan\OnlyLaravel\Translation\Filament\Resources\LanguageResource\Pages;
use Raakkan\OnlyLaravel\Translation\Models\Language;

class LanguageResource extends Resource
{
    protected static ?string $model = Language::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Translation';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->autofocus()->placeholder('English'),
                TextInput::make('locale')->required()->placeholder('en'),
                Toggle::make('is_active')->default(true),
                Toggle::make('is_default')
                    ->afterStateUpdated(function (Get $get, $state) {
                        $active = $get('is_active');
                        if ($state && $active) {
                            Language::where('is_default', true)->update(['is_default' => false]);
                        }
                    }),
                Toggle::make('rtl'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('locale'),
                ToggleColumn::make('is_default')->label('Default')
                    ->beforeStateUpdated(function ($record, $state) {
                        if ($state && $record->is_active) {
                            Language::where('is_default', true)->update(['is_default' => false]);
                        }
                    })
                    ->afterStateUpdated(function ($record, $state) {
                        if ($state && ! $record->is_active) {
                            $record->update(['is_default' => false]);

                            Notification::make()
                                ->title('Active language must be set as default')
                                ->warning()
                                ->send();
                        }
                    }),
                ToggleColumn::make('is_active')->label('Active'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListLanguages::route('/'),
            'create' => Pages\CreateLanguage::route('/create'),
            'edit' => Pages\EditLanguage::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
