<?php

namespace A21ns1g4ts\FilamentShop\Filament\Resources\BrandResource\Pages;

use A21ns1g4ts\FilamentShop\Filament\Exports\BrandExporter;
use A21ns1g4ts\FilamentShop\Filament\Resources\BrandResource;
use Filament\Actions;
use Filament\Actions\Exports\Models\Export;
use Filament\Resources\Pages\ListRecords;

class ListBrands extends ListRecords
{
    protected static string $resource = BrandResource::class;

    protected function getActions(): array
    {
        return [
            // TODO: Make laravel tenacy compatible
            // Actions\ExportAction::make()
            //     ->exporter(BrandExporter::class)
            //     ->modalHeading(__('filament-shop::default.brands.export_heading'))
            //     ->fileName(fn(Export $export): string => "brands-{$export->getKey()}.csv")
            //     ->fileDisk('s3')
            //     ->label(__('filament-shop::default.brands.export_label')),
            Actions\CreateAction::make(),
        ];
    }
}
