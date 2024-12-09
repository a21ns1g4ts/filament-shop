<?php

namespace A21ns1g4ts\FilamentShop\Filament\Clusters\Products\Resources\BrandResource\Pages;

use A21ns1g4ts\FilamentShop\Filament\Clusters\Products\Resources\BrandResource;
use A21ns1g4ts\FilamentShop\Filament\Exports\BrandExporter;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBrands extends ListRecords
{
    protected static string $resource = BrandResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ExportAction::make()
                ->exporter(BrandExporter::class),
            Actions\CreateAction::make(),
        ];
    }
}
