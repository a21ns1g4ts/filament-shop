<?php

namespace A21ns1g4ts\FilamentShop\Filament\Exports;

use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class BrandExporter extends Exporter
{
    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('name')
                ->label(__('filament-shop::default.brands.main.name.label')),
            ExportColumn::make('slug')
                ->label(__('filament-shop::default.brands.main.slug.label')),
            ExportColumn::make('website')
                ->label(__('filament-shop::default.brands.main.website.label')),
            ExportColumn::make('created_at')
                ->label(__('filament-shop::default.brands.main.created_at.label')),
            ExportColumn::make('updated_at')
                ->label(__('filament-shop::default.brands.main.updated_at.label')),
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
        return config('filament-shop.brands.model');
    }
}
