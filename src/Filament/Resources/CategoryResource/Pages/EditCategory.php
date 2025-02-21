<?php

namespace A21ns1g4ts\FilamentShop\Filament\Resources\CategoryResource\Pages;

use A21ns1g4ts\FilamentShop\Filament\Resources\CategoryResource;
use A21ns1g4ts\FilamentShop\Models\Category;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use JoseEspinal\RecordNavigation\Traits\HasRecordNavigation;

class EditCategory extends EditRecord
{
    use HasRecordNavigation;

    protected static string $resource = CategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function (Category $record, Actions\DeleteAction $action) {
                    $count = $record->products()->count();
                    if ($count > 0) {
                        Notification::make()
                            ->danger()
                            ->title(__('filament-shop::default.categories.notifications.cant_delete.title'))
                            ->body(__('filament-shop::default.categories.notifications.cant_delete.body', ['count' => $count]))
                            ->send();

                        return $action->cancel();
                    }
                }),
        ];
    }

    protected function getHeaderActions(): array
    {
        return array_merge(parent::getActions(), $this->getNavigationActions());
    }
}
