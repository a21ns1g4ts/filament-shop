<?php

namespace A21ns1g4ts\FilamentShop\Filament\Resources\BrandResource\Pages;

use A21ns1g4ts\FilamentShop\Filament\Resources\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBrand extends EditRecord
{
    protected static string $resource = BrandResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
