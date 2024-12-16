<?php

namespace A21ns1g4ts\FilamentShop\Filament\Resources;

use A21ns1g4ts\FilamentShop\Filament\Resources\BrandResource\Pages\CreateBrand;
use A21ns1g4ts\FilamentShop\Filament\Resources\BrandResource\Pages\EditBrand;
use A21ns1g4ts\FilamentShop\Filament\Resources\BrandResource\Pages\ListBrands;
use A21ns1g4ts\FilamentShop\Filament\Resources\CategoryResource\RelationManagers\ProductsRelationManager;
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
    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('filament-shop::default.brands.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-shop::default.brands.plural_model_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-shop::default.brands.navigation_label');
    }

    public static function getModel(): string
    {
        return config('filament-shop.brands.model');
    }

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
                            ]),

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
                    ->columnSpan(['lg' => fn (?Brand $record) => $record === null ? 3 : 2]),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label(__('filament-shop::default.brands.main.created_at.label'))
                            // @phpstan-ignore-next-line
                            ->content(fn (Brand $record): ?string => $record?->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label(__('filament-shop::default.brands.main.updated_at.label'))
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
                    ->label(__('filament-shop::default.brands.main.name.label'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('website')
                    ->label(__('filament-shop::default.brands.main.website.label'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('visible')
                    ->label(__('filament-shop::default.brands.main.visible.label'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('filament-shop::default.brands.main.updated_at.label'))
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
            'index' => ListBrands::route('/'),
            'create' => CreateBrand::route('/create'),
            'edit' => EditBrand::route('/{record}/edit'),
        ];
    }
}
