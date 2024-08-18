<?php

namespace Raakkan\OnlyLaravel\Filament\Resources;

use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Raakkan\OnlyLaravel\Models\PageModel;
use Raakkan\OnlyLaravel\Filament\Pages\Page\EditPage;
use Raakkan\OnlyLaravel\Filament\Pages\Page\ListPage;
use Raakkan\OnlyLaravel\Filament\Pages\Page\CreatePage;
use Raakkan\OnlyLaravel\Support\Validation\Rules\UniqueSlug;

class PageResource extends Resource
{
    protected static ?string $model = PageModel::class;

    protected static ?string $slug = 'pages';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('title')->required(),
                RichEditor::make('content')->columnSpanFull(),
                TextInput::make('slug')->required(),
                Select::make('template_id')->relationship('template', 'name')->required(),
                Select::make('status')->options([
                    'draft' => 'Draft',
                    'published' => 'Published',
                ])->default('published')->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('status')->searchable()->sortable(),
                TextColumn::make('template.name')->searchable()->sortable(),
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
            'index' => ListPage::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
        ];
    }

    public function getTitle(): string
    {
        return 'Pages';
    }

    public static function getNavigationLabel(): string
    {
        return 'Pages';
    }

    public static function getModelLabel(): string
    {
        return 'page';
    }
}
