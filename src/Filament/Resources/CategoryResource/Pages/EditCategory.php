<?php

namespace A21ns1g4ts\FilamentShop\Filament\Resources\CategoryResource\Pages;

use A21ns1g4ts\FilamentShop\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use JoseEspinal\RecordNavigation\Traits\HasRecordNavigation;

class EditCategory extends EditRecord
{
    use HasRecordNavigation;

    protected static string $resource = CategoryResource::class;

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
