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
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;
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
                        ->label(__('filament-shop::default.brands.main.name.label'))
                        ->weight(FontWeight::ExtraBold)
                        ->sortable()
                        ->searchable()
                        ->columnSpan(2),
                    Tables\Columns\ToggleColumn::make('visible')
                        ->label(__('filament-shop::default.categories.main.visible.label'))
                        ->sortable()
                        ->columnSpan(1),
                    Tables\Columns\TextColumn::make('website')
                        ->label(__('filament-shop::default.brands.main.website.label'))
                        ->weight(FontWeight::Medium)
                        ->columnSpan(3),
                ]),
        ];
    }

    private static function desktopColumns(Table $table): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label(__('filament-shop::default.brands.main.name.label'))
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('website')
                ->label(__('filament-shop::default.brands.main.website.label'))
                ->searchable()
                ->sortable()
                ->url(fn (Brand $record) => $record->website, true)
                ->toggleable(),

            Tables\Columns\TextColumn::make('updated_at')
                ->label(__('filament-shop::default.brands.main.updated_at.label'))
                ->date('d/m/Y H:i')
                ->sortable()
                ->toggleable()
                ->toggledHiddenByDefault()
                ->alignment(Alignment::End),

            Tables\Columns\TextColumn::make('created_at')
                ->label(__('filament-shop::default.brands.main.created_at.label'))
                ->date('d/m/Y H:i')
                ->sortable()
                ->toggleable()
                ->toggledHiddenByDefault()
                ->alignment(Alignment::End),

            Tables\Columns\ToggleColumn::make('visible')
                ->label(__('filament-shop::default.brands.main.visible.label'))
                ->sortable()
                ->toggleable()
                ->alignment(Alignment::End),
        ];
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

                        Forms\Components\Toggle::make('active')
                            ->label(__('filament-shop::default.brands.main.active.label'))
                            ->default(true),

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
            ->columns(self::isMobile() ? self::mobileColumns($table) : self::desktopColumns($table))
            ->filters([
                //
            ])
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
