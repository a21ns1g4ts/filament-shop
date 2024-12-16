<?php

namespace A21ns1g4ts\FilamentShop\Filament\Resources\CategoryResource\Pages;

use A21ns1g4ts\FilamentShop\Filament\Imports\CategoryImporter;
use A21ns1g4ts\FilamentShop\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getActions(): array
    {
        return [
            // TODO: First implemen products import
            // Actions\ImportAction::make()
            //     ->importer(CategoryImporter::class),
            Actions\CreateAction::make(),
        ];
    }
}
