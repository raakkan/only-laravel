<?php

namespace Raakkan\OnlyLaravel\Translation\Filament\Resources;

use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Config;
use Spatie\TranslationLoader\LanguageLine;
use Raakkan\OnlyLaravel\Translation\Models\Translation;
use Raakkan\OnlyLaravel\Translation\Filament\Resources\TranslationResource\Pages;
use Raakkan\OnlyLaravel\Translation\Services\ExcelImportExportService;

class TranslationResource extends Resource
{

    protected static ?string $model = Translation::class;

    protected static ?string $slug = 'translations';

    protected static ?string $recordTitleAttribute = 'key';
    protected static ?string $navigationGroup = 'Translation';

    protected static bool $isScopedToTenant  = false;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('group')
                ->label('Group')
                ->required()
                ->disabled(fn(Forms\Get $get) => $get('id') !== null)
                ->maxLength(255),
            Forms\Components\TextInput::make('key')
                ->label('Key')
                ->disabled(fn(Forms\Get $get) => $get('id') !== null)
                ->required()
                ->maxLength(255),
            \Raakkan\OnlyLaravel\Translation\Filament\Components\Translation::make('text')
                ->label('Text')
                ->columnSpanFull()

        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        $actions = [];
       
        $table
            ->headerActions($actions)
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Key')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('text')
                    ->label('Text')
                    ->view('only-laravel::filament.components.text-column')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
               Tables\Filters\SelectFilter::make('group')
                   ->label('Filter by Group')
                   ->options(fn (): array => LanguageLine::query()->groupBy('group')->pluck('group','group')->all()),
                Tables\Filters\Filter::make('text')
                    ->label('Filter by Null Text')
                    ->query(fn (Builder $query): Builder => $query->whereJsonContains('text',  []))
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);

            $table->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make()
                ]),
            ]);


        return $table;
    }

    public static function getPages(): array
    {
            return [
                'index' => Pages\ListTranslations::route('/'),
                'create' => Pages\CreateTranslation::route('/create'),
                'edit' => Pages\EditTranslation::route('/{record}/edit'),
            ];
    }
}
