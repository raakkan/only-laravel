<?php

namespace Raakkan\OnlyLaravel\Filament\Resources;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Raakkan\OnlyLaravel\Facades\PageManager;
use Raakkan\OnlyLaravel\Filament\Pages\Page\CreatePage;
use Raakkan\OnlyLaravel\Filament\Pages\Page\EditPage;
use Raakkan\OnlyLaravel\Filament\Pages\Page\ListPage;
use Raakkan\OnlyLaravel\Models\PageModel;

class PageResource extends Resource
{
    use Translatable;

    protected static ?string $model = PageModel::class;

    protected static ?string $slug = 'pages';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->unique(ignoreRecord: true)->live(onBlur: true)->required()->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->disabled(function (?Model $record) {
                        if ($record && ! app('page-manager')->getPageNameIsEditable($record->name)) {
                            return true;
                        }

                        return false;
                    })->rules('regex:/^[a-zA-Z0-9_-]+$/'),
                TextInput::make('title')->required(),
                RichEditor::make('content')->columnSpanFull(),
                TextInput::make('slug')->required()->disabled(function (?Model $record) {
                    if ($record && ! app('page-manager')->getPageSlugIsEditable($record->name)) {
                        return true;
                    }

                    return false;
                })->rules('regex:/^[a-zA-Z0-9_-]+$/'),
                Select::make('template_id')->relationship(
                    name: 'template',
                    titleAttribute: 'label',
                    modifyQueryUsing: function (Builder $query, ?Model $record) {
                        if ($record) {
                            return $query->where('type', '=', 'page')
                                ->whereIn('for', ['all', 'page', $record->name]);
                        } else {
                            return $query->where('type', '=', 'page')->whereIn('for', ['all', 'page']);
                        }
                    }
                )->required(),
                Toggle::make('disabled')->default(false)->disabled(function (?Model $record) {
                    if ($record && PageManager::pageIsDisableable($record->name)) {
                        return true;
                    }

                    return false;
                }),
                Section::make('Featured Media')
                    ->schema([
                        FileUpload::make('featured_image.image')
                            ->image()
                            ->disk('public')
                            ->directory('pages/featured-images')
                            ->label('Featured Image')
                            ->columnSpanFull(),
                        TextInput::make('featured_image.alt')
                            ->label('Featured Image Alt Text'),
                        Textarea::make('featured_image.caption')
                            ->label('Featured Image Caption'),
                    ])
                    ->collapsible()
                    ->columns(2),
                Section::make('SEO')
                    ->schema([
                        TextInput::make('seo_title')->label('SEO Title'),
                        TextInput::make('seo_keywords')->label('SEO Keywords'),
                        Textarea::make('seo_description')->label('SEO Description')->columnSpanFull()->rows(7),
                    ])
                    ->collapsed()->columns(2)->compact(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('template.label')->searchable()->sortable(),
                ToggleColumn::make('disabled')->disabled(function (?Model $record) {
                    if ($record && PageManager::pageIsDisableable($record->name)) {
                        return true;
                    }

                    return false;
                }),
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
