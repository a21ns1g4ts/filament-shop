<?php

namespace A21ns1g4ts\FilamentShop\Filament\Resources\ProductResource\Pages;

use A21ns1g4ts\FilamentShop\Filament\Exports\ProductExporter;
use A21ns1g4ts\FilamentShop\Filament\Imports\ProductImporter;
use A21ns1g4ts\FilamentShop\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Actions\Exports\Models\Export;
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
            // TODO: How to load in tenant context ?
            // Actions\ImportAction::make()
            //     ->importer(ProductImporter::class)
            //     ->modalHeading(__('filament-shop::default.products.import_heading'))
            //     ->label(__('filament-shop::default.products.import_label')),
            Actions\ExportAction::make()
                ->exporter(ProductExporter::class)
                ->modalHeading(__('filament-shop::default.products.export_heading'))
                ->fileName(fn (Export $export): string => "products-{$export->getKey()}.csv")
                ->label(__('filament-shop::default.products.export_label')),
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return ProductResource::getWidgets();
    }
}
