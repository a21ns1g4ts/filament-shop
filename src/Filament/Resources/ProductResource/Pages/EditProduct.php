<?php

namespace A21ns1g4ts\FilamentShop\Filament\Resources\ProductResource\Pages;

use A21ns1g4ts\FilamentShop\Filament\Resources\ProductResource;
use A21ns1g4ts\FilamentShop\FilamentShop;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use JoseEspinal\RecordNavigation\Traits\HasRecordNavigation;

class EditProduct extends EditRecord
{
    use HasRecordNavigation;

    protected static string $resource = ProductResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('remove_offer')
                ->label(__('filament-shop::default.products.pricing.offer.remove'))
                ->visible(isset($this->record->original_price))
                ->requiresConfirmation()
                ->action(function (): void {
                    $this->record->price = $this->record->original_price;
                    $this->record->original_price = null;
                    $this->record->save();

                    $this->refreshFormData([
                        'price',
                        'original_price',
                    ]);

                    Notification::make()
                        ->success()
                        ->title(__('filament-shop::default.products.pricing.offer.notifications.removed.title'))
                        ->body(__('filament-shop::default.products.pricing.offer.notifications.removed.body'))
                        ->send();
                }),
            Actions\Action::make('add_offer')
                ->label(__('filament-shop::default.products.pricing.offer.add'))
                ->modalSubmitActionLabel(__('filament-shop::default.products.pricing.offer.add'))
                ->outlined()
                ->visible(! $this->record->original_price)
                ->form([
                    Forms\Components\Group::make([
                        Forms\Components\TextInput::make('original_price')
                            ->required()
                            ->default(fn () => $this->record->original_price ?? $this->record->price)
                            ->disabled()
                            ->dehydrated()
                            ->label(__('filament-shop::default.products.pricing.original_price.label'))
                            ->currencyMask(FilamentShop::getThousandSeparator(), FilamentShop::getDecimalSeparator(), FilamentShop::getDecimalPrecision())
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('discount')
                            ->required()
                            ->live()
                            ->label(__('filament-shop::default.products.pricing.offer.discount'))
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                $originalPrice = $this->record->original_price ?? $this->record->price;
                                $set('price', $originalPrice - (float) $state);
                            })
                            ->lte('original_price')
                            ->currencyMask(FilamentShop::getThousandSeparator(), FilamentShop::getDecimalSeparator(), FilamentShop::getDecimalPrecision())
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->label(__('filament-shop::default.products.main.price.label'))
                            ->currencyMask(FilamentShop::getThousandSeparator(), FilamentShop::getDecimalSeparator(), FilamentShop::getDecimalPrecision())
                            ->columnSpan(2),
                    ])
                        ->columnSpanFull()
                        ->columns(6),
                ])
                ->action(function (array $data, Model $record): void {
                    if ($data['discount']) {
                        $record->price = $data['price'];
                        $record->original_price = $data['original_price'];
                        $record->save();

                        $this->refreshFormData([
                            'price',
                            'original_price',
                        ]);

                        Notification::make()
                            ->success()
                            ->title(__('filament-shop::default.products.pricing.offer.notifications.added.title'))
                            ->body(__('filament-shop::default.products.pricing.offer.notifications.added.body'))
                            ->send();
                    }
                }),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return array_merge(parent::getActions(), $this->getNavigationActions());
    }
}
