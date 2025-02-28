<?php

namespace A21ns1g4ts\FilamentShop\Filament\Exports;

use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProductExporter extends Exporter
{
    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('name')
                ->label(__('filament-shop::default.products.main.name.label')),
            ExportColumn::make('description')
                ->label(__('filament-shop::default.products.main.description.label')),
            ExportColumn::make('slug')
                ->label(__('filament-shop::default.products.main.slug.label')),
            ExportColumn::make('sku')
                ->label(__('filament-shop::default.products.inventory.sku.label')),
            ExportColumn::make('barcode')
                ->label(__('filament-shop::default.products.inventory.barcode.label')),
            ExportColumn::make('quantity')
                ->label(__('filament-shop::default.products.inventory.quantity.label')),
            ExportColumn::make('security_stock')
                ->label(__('filament-shop::default.products.inventory.security_stock.label')),
            ExportColumn::make('pinned')
                ->label(__('filament-shop::default.products.status.pinned.label')),
            ExportColumn::make('visible')
                ->label(__('filament-shop::default.products.status.visible.label')),
            ExportColumn::make('original_price')
                ->label(__('filament-shop::default.products.pricing.original_price.label')),
            ExportColumn::make('price')
                ->label(__('filament-shop::default.products.pricing.price.label')),
            ExportColumn::make('cost')
                ->label(__('filament-shop::default.products.pricing.cost.label')),
            ExportColumn::make('published_at')
                ->label(__('filament-shop::default.products.status.published_at.label')),
            ExportColumn::make('created_at')
                ->label(__('filament-shop::default.products.main.created_at.label')),
            ExportColumn::make('updated_at')
                ->label(__('filament-shop::default.products.main.updated_at.label')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $successfulRows = $export->successful_rows;
        $failedRowsCount = $export->getFailedRowsCount();

        $rowLabel = trans_choice('filament-shop::default.exports.row', $successfulRows);
        $body = '';

        if ($failedRowsCount) {
            $failedRowLabel = trans_choice('filament-shop::default.row', $failedRowsCount);
            $body .= ' ' . __('filament-shop::default.exports.export_failed', [
                'count' => number_format($failedRowsCount),
                'rows' => $failedRowLabel,
            ]);
        } else {
            $body = __('filament-shop::default.exports.export_successful', [
                'count' => number_format($successfulRows),
                'rows' => $rowLabel,
            ]);
        }

        return $body;
    }

    /**
     * @return class-string<Model>
     */
    public static function getModel(): string
    {
        return config('filament-shop.products.model');
    }
}
