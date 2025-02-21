<?php

namespace A21ns1g4ts\FilamentShop\Filament\Resources;

use A21ns1g4ts\FilamentShop\Filament\Resources\CategoryResource\Pages\CreateCategory;
use A21ns1g4ts\FilamentShop\Filament\Resources\CategoryResource\Pages\EditCategory;
use A21ns1g4ts\FilamentShop\Filament\Resources\CategoryResource\Pages\ListCategories;
use A21ns1g4ts\FilamentShop\Filament\Resources\CategoryResource\RelationManagers\ProductsRelationManager;
use A21ns1g4ts\FilamentShop\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use RalphJSmit\Filament\SEO\SEO;

class CategoryResource extends Resource
{
    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('filament-shop::default.categories.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-shop::default.categories.plural_model_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-shop::default.categories.navigation_label');
    }

    public static function getModel(): string
    {
        return config('filament-shop.categories.model');
    }

    public static function isScopedToTenant(): bool
    {
        return config('filament-shop.tenant_scope', false);
    }

    private static function isMobile(): bool
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';

        if (! is_string($userAgent) || empty($userAgent)) {
            return false;
        }

        return stripos($userAgent, 'mobile') !== false;
    }

    private static function mobileColumns(Table $table): array
    {
        return [
            Tables\Columns\Layout\Grid::make(3)
                ->schema([
                    Tables\Columns\TextColumn::make('name')
                        ->label(__('filament-shop::default.categories.main.name.label'))
                        ->weight(FontWeight::ExtraBold)
                        ->searchable()
                        ->sortable()
                        ->columnSpan(2),
                    Tables\Columns\ToggleColumn::make('visible')
                        ->label(__('filament-shop::default.categories.main.visible.label'))
                        ->sortable()
                        ->columnSpan(1),
                    Tables\Columns\TextColumn::make('description')
                        ->label(__('filament-shop::default.categories.main.description.label'))
                        ->weight(FontWeight::Medium)
                        ->searchable()
                        ->columnSpan(3),
                ]),

        ];
    }

    private static function desktopColumns(Table $table): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label(__('filament-shop::default.categories.main.name.label'))
                ->searchable()
                ->sortable(),
            // Tables\Columns\TextColumn::make('parent.name')
            //     ->label(__('filament-shop::default.categories.main.parent.label'))
            //     ->searchable()
            //     ->sortable()
            //     ->toggleable()
            //     ->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('updated_at')
                ->label(__('filament-shop::default.categories.main.updated_at.label'))
                ->date('d/m/Y H:i')
                ->sortable()
                ->toggleable()
                ->toggledHiddenByDefault()
                ->alignment(Alignment::End),
            Tables\Columns\TextColumn::make('created_at')
                ->label(__('filament-shop::default.categories.main.created_at.label'))
                ->date('d/m/Y H:i')
                ->sortable()
                ->toggleable()
                ->toggledHiddenByDefault()
                ->alignment(Alignment::End),
            Tables\Columns\ToggleColumn::make('visible')
                ->label(__('filament-shop::default.categories.main.visible.label'))
                ->sortable()
                ->toggleable()
                ->alignment(Alignment::End),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label(__('filament-shop::default.categories.main.name.label'))
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $set('slug', Str::slug($state))),

                                        Forms\Components\TextInput::make('slug')
                                            ->label(__('filament-shop::default.categories.main.slug.label'))
                                            ->disabled()
                                            ->dehydrated()
                                            ->required()
                                            ->maxLength(255),
                                    ]),

                                Forms\Components\Select::make('parent_id')
                                    ->label(__('filament-shop::default.categories.main.parent.label'))
                                    ->relationship('parent', 'name', fn (Builder $query) => $query->where('parent_id', null), ignoreRecord: true)
                                    ->preload()
                                    ->searchable()
                                    ->placeholder(__('filament-shop::default.categories.main.parent.placeholder')),

                                Forms\Components\Toggle::make('active')
                                    ->label(__('filament-shop::default.categories.main.active.label'))
                                    ->default(true),

                                Forms\Components\Toggle::make('visible')
                                    ->label(__('filament-shop::default.categories.main.visible.label'))
                                    ->default(true),

                                Forms\Components\MarkdownEditor::make('description')
                                    // TODO: add support for file attachments compatible with s3 storage
                                    ->disableToolbarButtons([
                                        'attachFiles',
                                    ])
                                    ->label(__('filament-shop::default.categories.main.description.label')),
                            ]),

                        // Forms\Components\Section::make('SEO')
                        //     ->description(__('filament-shop::default.seo.description'))
                        //     ->schema([
                        //         SEO::make(['title', 'description']),
                        //     ])
                        //     ->collapsible(),
                    ])
                    ->columnSpan(['lg' => fn (?Category $record) => $record === null ? 3 : 2]),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label(__('filament-shop::default.categories.main.created_at.label'))
                            // @phpstan-ignore-next-line
                            ->content(fn (Category $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label(__('filament-shop::default.categories.main.updated_at.label'))
                            // @phpstan-ignore-next-line
                            ->content(fn (Category $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Category $record) => $record === null),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::isMobile() ? self::mobileColumns($table) : self::desktopColumns($table))
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (Tables\Actions\DeleteAction $action, Category $record) {
                        $count = $record->products()->count();
                        if ($count > 0) {
                            Notification::make()
                                ->danger()
                                ->title(__('filament-shop::default.categories.notifications.cant_delete.title'))
                                ->body(__('filament-shop::default.categories.notifications.cant_delete.body', ['count' => $count]))
                                ->send();

                            return $action->cancel();
                        }
                    }),
            ])
            ->groupedBulkActions([
                // Tables\Actions\DeleteBulkAction::make()
                //     ->action(function () {
                //         Notification::make()
                //             ->title('Now, now, don\'t be cheeky, leave some records for others to play with!')
                //             ->warning()
                //             ->send();
                //     }),
            ])
            ->defaultSort('sort')
            ->reorderable('sort');
    }

    public static function getRelations(): array
    {
        return [
            ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
