<?php

namespace A21ns1g4ts\FilamentShop\Filament\Resources\ProductResource\Widgets;

use A21ns1g4ts\FilamentShop\Filament\Resources\ProductResource\Pages\ListProducts;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListProducts::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make(__('filament-shop::default.products.widgets.stats.overview.label'), $this->getPageTableQuery()->count()),
            Stat::make(__('filament-shop::default.products.widgets.stats.quantity.label'), $this->getPageTableQuery()->sum('quantity')),
            Stat::make(__('filament-shop::default.products.widgets.stats.average_price.label'), number_format($this->getPageTableQuery()->avg('price'), 2)),
        ];
    }
}
