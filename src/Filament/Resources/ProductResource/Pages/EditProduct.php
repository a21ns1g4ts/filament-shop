<?php

namespace A21ns1g4ts\FilamentShop\Filament\Resources\ProductResource\Pages;

use A21ns1g4ts\FilamentShop\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use JoseEspinal\RecordNavigation\Traits\HasRecordNavigation;

class EditProduct extends EditRecord
{
    use HasRecordNavigation;

    protected static string $resource = ProductResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return array_merge(parent::getActions(), $this->getNavigationActions());
    }
}
