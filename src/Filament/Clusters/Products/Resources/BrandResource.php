<?php

namespace A21ns1g4ts\FilamentShop\Filament\Clusters\Products\Resources;

use A21ns1g4ts\FilamentShop\Filament\Clusters\Products;
use A21ns1g4ts\FilamentShop\Filament\Clusters\Products\Resources\BrandResource\Pages\CreateBrand;
use A21ns1g4ts\FilamentShop\Filament\Clusters\Products\Resources\BrandResource\Pages\EditBrand;
use A21ns1g4ts\FilamentShop\Filament\Clusters\Products\Resources\BrandResource\Pages\ListBrands;
use A21ns1g4ts\FilamentShop\Filament\Clusters\Products\Resources\CategoryResource\RelationManagers\ProductsRelationManager;
use A21ns1g4ts\FilamentShop\Models\Brand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $cluster = Products::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

    protected static ?string $navigationParentItem = 'Products';

    protected static ?int $navigationSort = 2;

    public static function isScopedToTenant(): bool
    {
        return config('filament-shop.tenant_scope', false);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                                Forms\Components\TextInput::make('slug')
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Brand::class, 'slug', ignoreRecord: true),
                            ]),
                        Forms\Components\TextInput::make('website')
                            ->maxLength(255)
                            ->url(),

                        Forms\Components\Toggle::make('is_visible')
                            ->label('Visible to customers.')
                            ->default(true),

                        Forms\Components\MarkdownEditor::make('description')
                            ->label('Description'),
                    ])
                    ->columnSpan(['lg' => fn (?Brand $record) => $record === null ? 3 : 2]),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            // @phpstan-ignore-next-line
                            ->content(fn (Brand $record): ?string => $record?->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            // @phpstan-ignore-next-line
                            ->content(fn (Brand $record): ?string => $record?->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Brand $record) => $record === null),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('website')
                    ->label('Website')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_visible')
                    ->label('Visibility')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated Date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->groupedBulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->action(function () {
                        Notification::make()
                            ->title('Now, now, don\'t be cheeky, leave some records for others to play with!')
                            ->warning()
                            ->send();
                    }),
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
            'index' => ListBrands::route('/'),
            'create' => CreateBrand::route('/create'),
            'edit' => EditBrand::route('/{record}/edit'),
        ];
    }
}
