<?php

namespace A21ns1g4ts\FilamentShop\Filament\Clusters\Products\Resources\CategoryResource\Pages;

use A21ns1g4ts\FilamentShop\Filament\Clusters\Products\Resources\CategoryResource;
use A21ns1g4ts\FilamentShop\Filament\Imports\CategoryImporter;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ImportAction::make()
                ->importer(CategoryImporter::class),
            Actions\CreateAction::make(),
        ];
    }
}
