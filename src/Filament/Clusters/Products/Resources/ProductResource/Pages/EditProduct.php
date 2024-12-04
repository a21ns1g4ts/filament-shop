<?php

namespace A21ns1g4ts\FilamentShop\Filament\Clusters\Products\Resources\ProductResource\Pages;

use A21ns1g4ts\FilamentShop\Filament\Clusters\Products\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
