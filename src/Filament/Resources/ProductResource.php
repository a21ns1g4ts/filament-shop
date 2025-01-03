<?php

namespace A21ns1g4ts\FilamentShop\Filament\Resources;

use A21ns1g4ts\FilamentShop\Filament\Resources\CategoryResource\RelationManagers\ProductsRelationManager;
use A21ns1g4ts\FilamentShop\Filament\Resources\ProductResource\Pages\CreateProduct;
use A21ns1g4ts\FilamentShop\Filament\Resources\ProductResource\Pages\EditProduct;
use A21ns1g4ts\FilamentShop\Filament\Resources\ProductResource\Pages\ListProducts;
use A21ns1g4ts\FilamentShop\Filament\Resources\ProductResource\Widgets\ProductStats;
use A21ns1g4ts\FilamentShop\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
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
                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $set('slug', Str::slug($state))),

                                Forms\Components\TextInput::make('slug')
                                    ->label(__('filament-shop::default.products.main.slug.label'))
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\MarkdownEditor::make('description')
                                    // TODO: add support for file attachments compatible with s3 storage
                                    ->disableToolbarButtons([
                                        'attachFiles',
                                    ])
                                    ->label(__('filament-shop::default.products.main.description.label'))
                                    ->columnSpan('full'),
                            ])
                            ->columns(2),

                        Forms\Components\Section::make(__('filament-shop::default.products.main.images.label'))
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('media')
                                    ->collection('product-images')
                                    ->image()
                                    ->reorderable()
                                    ->multiple()
                                    ->maxFiles(5)
                                    ->hiddenLabel(),
                            ])
                            ->collapsible(),

                        Forms\Components\Section::make('SEO')
                            ->description(__('filament-shop::default.seo.description'))
                            ->schema([
                                SEO::make(['title', 'description']),
                            ])
                            ->collapsible(),

                        Forms\Components\Section::make(__('filament-shop::default.products.pricing.label'))
                            ->description(__('filament-shop::default.products.pricing.description'))
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->label(__('filament-shop::default.products.pricing.price.label'))
                                    ->helperText(__('filament-shop::default.products.pricing.price.helper_text'))
                                    ->numeric()
                                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                    ->required(),

                                Forms\Components\TextInput::make('original_price')
                                    ->label(__('filament-shop::default.products.pricing.original_price.label'))
                                    ->helperText(__('filament-shop::default.products.pricing.original_price.helper_text'))
                                    ->numeric()
                                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/']),

                                Forms\Components\TextInput::make('cost')
                                    ->label(__('filament-shop::default.products.pricing.cost.label'))
                                    ->helperText(__('filament-shop::default.products.pricing.cost.helper_text'))
                                    ->numeric()
                                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/']),
                            ])
                            ->columns(2),

                        Forms\Components\Section::make(__('filament-shop::default.products.inventory.label'))
                            ->schema([
                                Forms\Components\TextInput::make('sku')
                                    ->label(__('filament-shop::default.products.inventory.sku.label'))
                                    ->helperText(__('filament-shop::default.products.inventory.sku.helper_text'))
                                    ->unique(Product::class, 'sku', ignoreRecord: true)
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('barcode')
                                    ->label(__('filament-shop::default.products.inventory.barcode.label'))
                                    ->helperText(__('filament-shop::default.products.inventory.barcode.helper_text'))
                                    ->unique(Product::class, 'barcode', ignoreRecord: true)
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('quantity')
                                    ->label(__('filament-shop::default.products.inventory.quantity.label'))
                                    ->helperText(__('filament-shop::default.products.inventory.quantity.helper_text'))
                                    ->numeric()
                                    ->rules(['integer', 'min:0'])
                                    ->required(),

                                Forms\Components\TextInput::make('security_stock')
                                    ->label(__('filament-shop::default.products.inventory.security_stock.label'))
                                    ->helperText(__('filament-shop::default.products.inventory.security_stock.helper_text'))
                                    ->numeric()
                                    ->rules(['integer', 'min:0'])
                                    ->required(),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make(__('filament-shop::default.products.status.label'))
                            ->schema([
                                Forms\Components\Toggle::make('visible')
                                    ->label(__('filament-shop::default.products.status.visible.label'))
                                    ->helperText(__('filament-shop::default.products.status.visible.helper_text'))
                                    ->default(true),

                                Forms\Components\Checkbox::make('pinned')
                                    ->label(__('filament-shop::default.products.status.pinned.label'))
                                    ->helperText(__('filament-shop::default.products.status.pinned.helper_text')),

                                Forms\Components\DatePicker::make('published_at')
                                    ->label(__('filament-shop::default.products.status.published_at.label'))
                                    ->helperText(__('filament-shop::default.products.status.published_at.helper_text'))
                                    ->default(now())
                                    ->required(),
                            ]),

                        Forms\Components\Section::make(__('filament-shop::default.products.associations.label'))
                            ->schema([
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

                                        Forms\Components\Toggle::make('visible')
                                            ->label(__('filament-shop::default.brands.main.visible.label'))
                                            ->default(true),

                                        Forms\Components\MarkdownEditor::make('description')
                                            // TODO: add support for file attachments compatible with s3 storage
                                            ->disableToolbarButtons([
                                                'attachFiles',
                                            ])
                                            ->label(__('filament-shop::default.brands.main.description.label')),
                                    ])
                                    ->createOptionAction(function (Action $action) {
                                        return $action
                                            ->modalHeading('Criar Marca')
                                            ->modalSubmitActionLabel('Criar')
                                            ->modalWidth('lg');
                                    }),

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

                                        Forms\Components\Toggle::make('visible')
                                            ->label(__('filament-shop::default.categories.main.visible.label'))
                                            ->default(true),

                                        Forms\Components\MarkdownEditor::make('description')
                                            // TODO: add support for file attachments compatible with s3 storage
                                            ->disableToolbarButtons([
                                                'attachFiles',
                                            ])
                                            ->label(__('filament-shop::default.categories.main.description.label')),
                                    ])
                                    ->createOptionAction(function (Action $action) {
                                        return $action
                                            ->modalHeading('Criar Categoria')
                                            ->modalSubmitActionLabel('Criar')
                                            ->modalWidth('lg');
                                    }),
                            ]),

                        Forms\Components\Section::make(__('filament-shop::default.products.meta.label'))
                            ->schema([
                                Forms\Components\KeyValue::make('meta')
                                    ->label(__('filament-shop::default.products.meta.label')),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('product-image')
                    ->label('Image')
                    ->filterMediaUsing(
                        fn (Collection $media): Collection => $media->take(3),
                    )
                    ->collection('product-images'),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament-shop::default.products.main.name.label'))
                    ->wrap()
                    ->width('300px')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\IconColumn::make('visible')
                    ->label(__('filament-shop::default.products.status.visible.label'))
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('price')
                    ->label(__('filament-shop::default.products.pricing.price.label'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('sku')
                    ->label(__('filament-shop::default.products.inventory.sku.label'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('filament-shop::default.products.inventory.quantity.label'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('security_stock')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publish Date')
                    ->date()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        TextConstraint::make('name')
                            ->label(__('filament-shop::default.products.main.name.label')),
                        TextConstraint::make('slug')
                            ->label(__('filament-shop::default.products.main.slug.label')),
                        TextConstraint::make('sku')
                            ->label(__('filament-shop::default.products.inventory.sku.label')),
                        TextConstraint::make('barcode')
                            ->label(__('filament-shop::default.products.inventory.barcode.label')),
                        TextConstraint::make('description'),
                        NumberConstraint::make('original_price')
                            ->label(__('filament-shop::default.products.pricing.original_price.label'))
                            ->icon('heroicon-m-currency-dollar'),
                        NumberConstraint::make('price')
                            ->label(__('filament-shop::default.products.pricing.price.label'))
                            ->icon('heroicon-m-currency-dollar'),
                        NumberConstraint::make('cost')
                            ->label(__('filament-shop::default.products.pricing.cost.label'))
                            ->icon('heroicon-m-currency-dollar'),
                        NumberConstraint::make('quantity')
                            ->label(__('filament-shop::default.products.inventory.quantity.label')),
                        NumberConstraint::make('security_stock')
                            ->label(__('filament-shop::default.products.inventory.security_stock.label')),
                        BooleanConstraint::make('visible')
                            ->label(__('filament-shop::default.products.status.visible.label')),
                        BooleanConstraint::make('pinned')
                            ->label(__('filament-shop::default.products.status.pinned.label')),
                        DateConstraint::make('published_at')
                            ->label(__('filament-shop::default.products.status.published_at.label')),
                    ])
                    ->constraintPickerColumns(2),
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            ->deferFilters()
            ->actions([
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
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getWidgets(): array
    {
        return [
            ProductStats::class,
        ];
    }

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
        return ['name', 'sku', 'brand.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var Product $record */

        return [
            'Brand' => optional($record->brand)->name,
        ];
    }

    /** @return Builder<Product> */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['brand']);
    }

    public static function getNavigationBadge(): ?string
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::getModel();

        // return (string) $modelClass::whereColumn('quantity', '<', 'security_stock')->count();
        return (string) $modelClass::count();
    }
}
