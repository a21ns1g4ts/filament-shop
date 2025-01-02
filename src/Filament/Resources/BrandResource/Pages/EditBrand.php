<?php

namespace A21ns1g4ts\FilamentShop\Filament\Resources\BrandResource\Pages;

use A21ns1g4ts\FilamentShop\Filament\Resources\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use JoseEspinal\RecordNavigation\Traits\HasRecordNavigation;

class EditBrand extends EditRecord
{
    use HasRecordNavigation;

    protected static string $resource = BrandResource::class;

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
