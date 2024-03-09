<?php

namespace A21ns1g4ts\FilamentShop\Filament\Resources\CategoryResource\RelationManagers;

use A21ns1g4ts\FilamentShop\Filament\Resources\ProductResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('filament-shop::default.products.plural_model_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament-shop::default.products.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-shop::default.products.plural_model_label');
    }

    public function form(Form $form): Form
    {
        return ProductResource::form($form);
    }

    public function table(Table $table): Table
    {
        return ProductResource::table($table)
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->groupedBulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('product_id');
    }
}
