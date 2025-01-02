<?php

namespace A21ns1g4ts\FilamentShop\Filament\Resources\ProductResource\Pages;

use A21ns1g4ts\FilamentShop\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;
use JoseEspinal\RecordNavigation\Traits\HasRecordsList;

class ListProducts extends ListRecords
{
    use ExposesTableToWidgets;
    use HasRecordsList;

    protected static string $resource = ProductResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return ProductResource::getWidgets();
    }
}
