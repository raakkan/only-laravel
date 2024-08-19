<?php

namespace Raakkan\OnlyLaravel\Filament\Resources;

use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
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
                TextInput::make('name')->live(onBlur: true)->required()->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                ->disabled(fn (?Model $record) => $record->name === 'home-page')->rules('regex:/^[a-zA-Z0-9_-]+$/'),
                TextInput::make('title')->required(),
                RichEditor::make('content')->columnSpanFull(),
                TextInput::make('slug')->required()->rules('regex:/^[a-zA-Z0-9_-]+$/'),
                Select::make('template_id')->relationship(
                    name: 'template',
                    titleAttribute: 'label',
                    modifyQueryUsing: function (Builder $query, ?Model $record) {
                        if ($record) {
                            return $query->where('for_page_type', '=', 'page')->where('for_page', '=', 'all')->orWhere('for_page', '=', $record->name);
                        }else{
                            return $query->where('for_page_type', '=', 'page')->where('for_page', '=', 'all');
                        }
                    }
                )->required(),
                Toggle::make('disabled')->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('status')->searchable()->sortable(),
                TextColumn::make('template.label')->searchable()->sortable(),
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
