<?php

namespace A21ns1g4ts\FilamentShop\Filament\Resources;

use A21ns1g4ts\FilamentShop\Filament\Resources\CategoryResource\RelationManagers\ProductsRelationManager;
use A21ns1g4ts\FilamentShop\Filament\Resources\ProductResource\Pages\CreateProduct;
use A21ns1g4ts\FilamentShop\Filament\Resources\ProductResource\Pages\EditProduct;
use A21ns1g4ts\FilamentShop\Filament\Resources\ProductResource\Pages\ListProducts;
use A21ns1g4ts\FilamentShop\Filament\Resources\ProductResource\Widgets\ProductStats;
use A21ns1g4ts\FilamentShop\FilamentShop;
use A21ns1g4ts\FilamentShop\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\BooleanConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use RalphJSmit\Filament\SEO\SEO;

class ProductResource extends Resource
{
    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?int $navigationSort = 0;

    public static function getModelLabel(): string
    {
        return __('filament-shop::default.products.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-shop::default.products.plural_model_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-shop::default.products.navigation_label');
    }

    public static function getModel(): string
    {
        return config('filament-shop.products.model');
    }

    public static function isScopedToTenant(): bool
    {
        return config('filament-shop.tenant_scope', false);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('filament-shop::default.products.main.name.label'))
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $set('slug', Str::slug($state)))
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('slug')
                                    ->label(__('filament-shop::default.products.main.slug.label'))
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Forms\Components\Group::make([
                                    Forms\Components\TextInput::make('price')
                                        ->required()
                                        ->label(__('filament-shop::default.products.pricing.price.label'))
                                        ->helperText(__('filament-shop::default.products.main.price.helper_text'))
                                        ->currencyMask(FilamentShop::getThousandSeparator(), FilamentShop::getDecimalSeparator(), FilamentShop::getDecimalPrecision())
                                        ->columnSpan(1),

                                    Forms\Components\TextInput::make('original_price')
                                        ->disabled()
                                        ->label(__('filament-shop::default.products.pricing.original_price.label'))
                                        ->helperText(__('filament-shop::default.products.pricing.original_price.helper_text'))
                                        ->currencyMask(FilamentShop::getThousandSeparator(), FilamentShop::getDecimalSeparator(), FilamentShop::getDecimalPrecision())
                                        ->columnSpan(1),
                                ])
                                    ->columnSpanFull()
                                    ->columns(2),

                                Forms\Components\RichEditor::make('description')
                                    // TODO: add support for file attachments compatible with s3 storage
                                    ->disableToolbarButtons([
                                        'attachFiles',
                                    ])
                                    ->label(__('filament-shop::default.products.main.description.label'))
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        // Forms\Components\Section::make(__('filament-shop::default.products.pricing.label'))
                        //     ->schema([
                        //         Forms\Components\TextInput::make('price')
                        //             ->label(__('filament-shop::default.products.pricing.price.label'))
                        //             ->helperText(__('filament-shop::default.products.pricing.price.helper_text'))
                        //             ->required()
                        //             ->currencyMask(FilamentShop::getThousandSeparator(), FilamentShop::getDecimalSeparator(), FilamentShop::getDecimalPrecision()),

                        //         Forms\Components\TextInput::make('original_price')
                        //             ->label(__('filament-shop::default.products.pricing.original_price.label'))
                        //             ->helperText(__('filament-shop::default.products.pricing.original_price.helper_text'))
                        //             ->currencyMask(FilamentShop::getThousandSeparator(), FilamentShop::getDecimalSeparator(), FilamentShop::getDecimalPrecision()),

                        //         Forms\Components\TextInput::make('cost')
                        //             ->label(__('filament-shop::default.products.pricing.cost.label'))
                        //             ->helperText(__('filament-shop::default.products.pricing.cost.helper_text'))
                        //             ->currencyMask(FilamentShop::getThousandSeparator(), FilamentShop::getDecimalSeparator(), FilamentShop::getDecimalPrecision()),
                        //     ])
                        //     ->collapsible()
                        //     ->columns(3),

                        Forms\Components\Section::make(__('filament-shop::default.products.main.images.label'))
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('media')
                                    ->collection('product-images')
                                    ->image()
                                    ->reorderable()
                                    ->downloadable()
                                    ->openable()
                                    ->multiple()
                                    ->maxFiles(5)
                                    ->hiddenLabel(),
                            ])
                            ->collapsible(),

                        // Forms\Components\Section::make('SEO')
                        //     ->description(__('filament-shop::default.seo.description'))
                        //     ->schema([
                        //         SEO::make(['title', 'description']),
                        //     ])
                        //     ->collapsible()
                        //     ->collapsed(),
                    ])
                    ->columnSpan(2),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make(__('filament-shop::default.products.status.label'))
                            ->schema([
                                Forms\Components\Toggle::make('visible')
                                    ->label(__('filament-shop::default.products.status.visible.label'))
                                    ->helperText(__('filament-shop::default.products.status.visible.helper_text'))
                                    ->default(true),

                                // Forms\Components\Checkbox::make('pinned')
                                //     ->label(__('filament-shop::default.products.status.pinned.label'))
                                //     ->helperText(__('filament-shop::default.products.status.pinned.helper_text')),

                                // Forms\Components\DatePicker::make('published_at')
                                //     ->label(__('filament-shop::default.products.status.published_at.label'))
                                //     ->helperText(__('filament-shop::default.products.status.published_at.helper_text'))
                                //     ->default(now())
                                //     ->required(),
                            ]),

                        Forms\Components\Section::make(__('filament-shop::default.products.associations.label'))
                            ->schema([
                                Forms\Components\Select::make('categories')
                                    ->label(__('filament-shop::default.products.associations.categories.label'))
                                    ->helperText(__('filament-shop::default.products.associations.categories.helper_text'))
                                    ->relationship('categories', 'name')
                                    ->preload()
                                    ->multiple()
                                    ->required()
                                    ->hiddenOn(ProductsRelationManager::class)
                                    ->createOptionForm([
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

                                        Forms\Components\RichEditor::make('description')
                                            // TODO: add support for file attachments compatible with s3 storage
                                            ->disableToolbarButtons([
                                                'attachFiles',
                                            ])
                                            ->label(__('filament-shop::default.categories.main.description.label')),
                                    ])
                                    ->createOptionAction(function (Action $action) {
                                        return $action
                                            ->modalHeading(__('filament-shop::default.categories.create_new'))
                                            ->modalSubmitActionLabel(__('filament-shop::default.common.create'))
                                            ->modalWidth('lg');
                                    }),

                                Forms\Components\Select::make('brand_id')
                                    ->label(__('filament-shop::default.products.associations.brand.label'))
                                    ->relationship('brand', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label(__('filament-shop::default.brands.main.name.label'))
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $set('slug', Str::slug($state))),

                                        Forms\Components\TextInput::make('slug')
                                            ->label(__('filament-shop::default.brands.main.slug.label'))
                                            ->disabled()
                                            ->dehydrated()
                                            ->required()
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('website')
                                            ->label(__('filament-shop::default.brands.main.website.label'))
                                            ->maxLength(255)
                                            ->url(),

                                        Forms\Components\Toggle::make('active')
                                            ->label(__('filament-shop::default.brands.main.active.label'))
                                            ->default(true),

                                        Forms\Components\Toggle::make('visible')
                                            ->label(__('filament-shop::default.brands.main.visible.label'))
                                            ->default(true),

                                        Forms\Components\RichEditor::make('description')
                                            // TODO: add support for file attachments compatible with s3 storage
                                            ->disableToolbarButtons([
                                                'attachFiles',
                                            ])
                                            ->label(__('filament-shop::default.brands.main.description.label')),
                                    ])
                                    ->createOptionAction(function (Action $action) {
                                        return $action
                                            ->modalHeading(__('filament-shop::default.brands.create_new'))
                                            ->modalSubmitActionLabel(__('filament-shop::default.common.create'))
                                            ->modalWidth('lg');
                                    }),
                            ]),

                        // Forms\Components\Section::make(__('filament-shop::default.products.meta.label'))
                        //     ->schema([
                        //         Forms\Components\KeyValue::make('meta')
                        //             ->label(__('filament-shop::default.products.meta.label')),
                        //     ]),

                        Forms\Components\Section::make(__('filament-shop::default.products.inventory.label'))
                            ->schema([
                                Forms\Components\TextInput::make('sku')
                                    ->label(__('filament-shop::default.products.inventory.sku.label'))
                                    ->helperText(__('filament-shop::default.products.inventory.sku.helper_text'))
                                    ->unique(Product::class, 'sku', ignoreRecord: true)
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('barcode')
                                    ->label(__('filament-shop::default.products.inventory.barcode.label'))
                                    ->helperText(__('filament-shop::default.products.inventory.barcode.helper_text'))
                                    ->unique(Product::class, 'barcode', ignoreRecord: true)
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                // Forms\Components\TextInput::make('quantity')
                                //     ->label(__('filament-shop::default.products.inventory.quantity.label'))
                                //     ->helperText(__('filament-shop::default.products.inventory.quantity.helper_text'))
                                //     ->numeric()
                                //     ->rules(['integer', 'min:0', 'nullable']),

                                // Forms\Components\TextInput::make('security_stock')
                                //     ->label(__('filament-shop::default.products.inventory.security_stock.label'))
                                //     ->helperText(__('filament-shop::default.products.inventory.security_stock.helper_text'))
                                //     ->numeric()
                                //     ->rules(['integer', 'min:0', 'nullable']),
                            ])
                            ->collapsible()
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    private static function getLabelRaw(string $label, string $icon)
    {
        return new HtmlString(Blade::render('<div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">' . '<x-' . $icon . ' class="w-4 h-6" />' . $label . '</div>'));
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
            Tables\Columns\Layout\Grid::make()
                ->schema([
                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\SpatieMediaLibraryImageColumn::make('product-image')
                            ->label(__('filament-shop::default.products.main.images.label'))
                            ->filterMediaUsing(
                                fn (Collection $media): Collection => $media->reverse()->take(1),
                            )
                            ->collection('product-images')
                            ->square()
                            ->height('80px')
                            ->stacked()
                            ->grow(false),

                        \Filament\Tables\Columns\Layout\Grid::make()
                            ->schema([
                                Tables\Columns\Layout\Stack::make([
                                    Tables\Columns\TextColumn::make('name')
                                        ->label(('filament-shop::default.products.main.name.label'))
                                        ->weight(FontWeight::Medium)
                                        ->searchable(),

                                    Tables\Columns\TextColumn::make('price')
                                        ->label(__('filament-shop::default.products.pricing.price.label'))
                                        ->weight(FontWeight::ExtraBold)
                                        ->currency(FilamentShop::getCurrency())
                                        ->icon('heroicon-m-currency-dollar'),
                                ]),
                            ]),

                    ]),
                ]),

            Tables\Columns\Layout\Panel::make([
                Tables\Columns\TextColumn::make('description')
                    ->label(__('filament-shop::default.products.main.description.label'))
                    ->wrap()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('categories.name')
                    ->badge(),
            ])
                ->collapsed(true),
        ];
    }

    private static function desktopColumns(Table $table): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                ->label(self::getLabelRaw('ID', 'heroicon-c-identification'))
                ->copyable()
                ->sortable()
                ->toggleable()
                ->toggledHiddenByDefault(),

            Tables\Columns\SpatieMediaLibraryImageColumn::make('product-image')
                ->label(self::getLabelRaw(__('filament-shop::default.products.main.images.label'), 'heroicon-c-photo'))
                ->filterMediaUsing(
                    fn (Collection $media): Collection => $media->reverse()->take(1),
                )
                ->collection('product-images')
                ->square()
                ->height('80px')
                ->stacked()
                ->toggleable()
                ->grow(false),

            Tables\Columns\TextColumn::make('name')
                ->label(self::getLabelRaw(__('filament-shop::default.products.main.name.label'), 'heroicon-c-square-3-stack-3d'))
                ->weight(FontWeight::Medium)
                ->wrap()
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('categories.name')
                ->label(self::getLabelRaw(__('filament-shop::default.products.associations.categories.label'), 'heroicon-s-tag'))
                ->badge()
                ->searchable()
                ->sortable()
                ->toggleable()
                ->toggledHiddenByDefault(),

            Tables\Columns\TextColumn::make('brand.name')
                ->label(self::getLabelRaw(__('filament-shop::default.products.associations.brand.label'), 'heroicon-c-tag'))
                ->searchable()
                ->sortable()
                ->toggleable()
                ->toggledHiddenByDefault(),

            Tables\Columns\TextColumn::make('price')
                ->label(self::getLabelRaw(__('filament-shop::default.products.pricing.price.label'), 'heroicon-c-currency-dollar'))
                ->weight(FontWeight::ExtraBold)
                ->currency(FilamentShop::getCurrency())
                ->sortable()
                ->toggleable()
                ->alignment(Alignment::End),

            // Tables\Columns\TextColumn::make('original_price')
            //     ->label(self::getLabelRaw(__('filament-shop::default.products.pricing.original_price.label'), 'heroicon-c-currency-dollar'))
            //     ->currency(FilamentShop::getCurrency())
            //     ->sortable()
            //     ->toggleable()
            //     ->toggledHiddenByDefault()
            //     ->alignment(Alignment::End),

            // Tables\Columns\TextColumn::make('cost')
            //     ->label(self::getLabelRaw(__('filament-shop::default.products.pricing.cost.label'), 'heroicon-c-currency-dollar'))
            //     ->currency(FilamentShop::getCurrency())
            //     ->sortable()
            //     ->toggleable()
            //     ->toggledHiddenByDefault()
            //     ->alignment(Alignment::End),

            Tables\Columns\TextColumn::make('sku')
                ->label(self::getLabelRaw(__('filament-shop::default.products.inventory.sku.label'), 'heroicon-c-tag'))
                ->copyable()
                ->weight(FontWeight::ExtraBold)
                ->searchable()
                ->sortable()
                ->toggleable()
                ->toggledHiddenByDefault()
                ->alignment(Alignment::End),

            Tables\Columns\ToggleColumn::make('visible')
                ->label(self::getLabelRaw(__('filament-shop::default.products.status.visible.label'), 'heroicon-c-eye'))
                ->sortable()
                ->toggleable()
                ->alignment(Alignment::End),

            // Tables\Columns\ToggleColumn::make('pinned')
            //     ->label(self::getLabelRaw(__('filament-shop::default.products.status.pinned.label'), 'heroicon-c-map-pin'))
            //     ->sortable()
            //     ->toggleable(),

            // Tables\Columns\TextColumn::make('quantity')
            //     ->label(self::getLabelRaw(__('filament-shop::default.products.inventory.quantity.label'), 'heroicon-c-cube'))
            //     ->weight(FontWeight::ExtraBold)
            //     ->searchable()
            //     ->sortable()
            //     ->toggleable()
            //     ->toggledHiddenByDefault(),

            // Tables\Columns\TextColumn::make('security_stock')
            //     ->label(self::getLabelRaw(__('filament-shop::default.products.inventory.security_stock.label'), 'heroicon-c-lock-closed'))
            //     ->searchable()
            //     ->sortable()
            //     ->toggleable()
            //     ->toggledHiddenByDefault(),

            // Tables\Columns\TextColumn::make('published_at')
            //     ->label(self::getLabelRaw(__('filament-shop::default.products.status.published_at.label'), 'heroicon-c-calendar'))
            //     ->date('d/m/Y H:i')
            //     ->sortable()
            //     ->toggleable()
            //     ->toggledHiddenByDefault()
            //     ->alignment(Alignment::End),

            Tables\Columns\TextColumn::make('created_at')
                ->label(self::getLabelRaw(__('filament-shop::default.products.main.created_at.label'), 'heroicon-c-calendar'))
                ->date('d/m/Y H:i')
                ->sortable()
                ->toggleable()
                ->toggledHiddenByDefault()
                ->alignment(Alignment::End),

            Tables\Columns\TextColumn::make('updated_at')
                ->label(self::getLabelRaw(__('filament-shop::default.products.main.updated_at.label'), 'heroicon-c-calendar'))
                ->date('d/m/Y H:i')
                ->sortable()
                ->toggleable()
                ->toggledHiddenByDefault()
                ->alignment(Alignment::End),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::isMobile() ? self::mobileColumns($table) : self::desktopColumns($table))
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('categories')
                    ->label(__('filament-shop::default.products.associations.categories.label'))
                    ->relationship('categories', 'name')
                    ->preload()
                    ->multiple(),
                \Filament\Tables\Filters\SelectFilter::make('brand_id')
                    ->label(__('filament-shop::default.products.associations.brand.label'))
                    ->relationship('brand', 'name')
                    ->preload()
                    ->multiple(),
                // QueryBuilder::make()
                //     ->constraints([
                //         TextConstraint::make('name')
                //             ->label(__('filament-shop::default.products.main.name.label')),
                //         TextConstraint::make('slug')
                //             ->label(__('filament-shop::default.products.main.slug.label')),
                //         TextConstraint::make('sku')
                //             ->label(__('filament-shop::default.products.inventory.sku.label')),
                //         TextConstraint::make('barcode')
                //             ->label(__('filament-shop::default.products.inventory.barcode.label')),
                //         TextConstraint::make('description'),
                //         NumberConstraint::make('original_price')
                //             ->label(__('filament-shop::default.products.pricing.original_price.label'))
                //             ->icon('heroicon-m-currency-dollar'),
                //         NumberConstraint::make('price')
                //             ->label(__('filament-shop::default.products.pricing.price.label'))
                //             ->icon('heroicon-m-currency-dollar'),
                //         NumberConstraint::make('cost')
                //             ->label(__('filament-shop::default.products.pricing.cost.label'))
                //             ->icon('heroicon-m-currency-dollar'),
                //         NumberConstraint::make('quantity')
                //             ->label(__('filament-shop::default.products.inventory.quantity.label')),
                //         NumberConstraint::make('security_stock')
                //             ->label(__('filament-shop::default.products.inventory.security_stock.label')),
                //         BooleanConstraint::make('visible')
                //             ->label(__('filament-shop::default.products.status.visible.label')),
                //         BooleanConstraint::make('pinned')
                //             ->label(__('filament-shop::default.products.status.pinned.label')),
                //         DateConstraint::make('published_at')
                //             ->label(__('filament-shop::default.products.status.published_at.label')),
                //     ])
                //     ->constraintPickerColumns(2),
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            // ->deferFilters()
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            ->defaultSort('id', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    // public static function getWidgets(): array
    // {
    //     return self::isMobile() ? [] : [
    //         ProductStats::class,
    //     ];
    // }

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'sku'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            __('filament-shop::default.categories.plural_model_label') => optional($record->categories)->pluck('name')->implode(', '),
        ];
    }

    /** @return Builder<Product> */
    // public static function getGlobalSearchEloquentQuery(): Builder
    // {
    //     return parent::getGlobalSearchEloquentQuery()->with(['brand']);
    // }

    public static function getNavigationBadge(): ?string
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::getModel();

        // return (string) $modelClass::whereColumn('quantity', '<', 'security_stock')->count();
        return (string) $modelClass::count();
    }
}
