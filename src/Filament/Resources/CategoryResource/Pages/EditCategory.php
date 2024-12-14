<?php

namespace A21ns1g4ts\FilamentShop\Filament\Resources\CategoryResource\Pages;

use A21ns1g4ts\FilamentShop\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
