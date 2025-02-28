<?php

namespace A21ns1g4ts\FilamentShop\Filament\Imports;

use A21ns1g4ts\FilamentShop\Models\Product;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

// TODO: How to load in tenant context ?
class ProductImporter extends Importer
{
    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->example('Product A'),
            ImportColumn::make('meta')
                ->example(json_encode(['key' => 'value'])),
            ImportColumn::make('slug')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->example('product-a'),
            ImportColumn::make('sku')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->example('SKU12345'),
            ImportColumn::make('barcode')
                ->rules(['nullable', 'max:255'])
                ->example('7891234567890'),
            ImportColumn::make('description')
                ->example('This is a description of Product A.'),
            ImportColumn::make('quantity')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer'])
                ->example('100'),
            ImportColumn::make('security_stock')
                ->numeric()
                ->rules(['nullable', 'integer'])
                ->example('10'),
            ImportColumn::make('pinned')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean'])
                ->example('1'),
            ImportColumn::make('visible')
                ->label('Visibility')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean'])
                ->example('1'),
            ImportColumn::make('original_price')
                ->numeric()
                ->rules(['nullable', 'numeric'])
                ->example('199.99'),
            ImportColumn::make('price')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'numeric'])
                ->example('149.99'),
            ImportColumn::make('cost')
                ->numeric()
                ->rules(['nullable', 'numeric'])
                ->example('100.00'),
            ImportColumn::make('published_at')
                ->date()
                ->rules(['nullable', 'date'])
                ->example('2024-02-27 12:00:00'),
            ImportColumn::make('brand')
                ->relationship(resolveUsing: ['id', 'name'])
                ->example('Brand X'),
            ImportColumn::make('categories')
                ->relationship(resolveUsing: ['id', 'name'])
                ->example('Category A, Category B'),
        ];
    }

    public function resolveRecord(): ?Product
    {
        return Product::firstOrNew([
            'slug' => $this->data['slug'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $successfulRows = $import->successful_rows;
        $failedRowsCount = $import->getFailedRowsCount();

        $rowLabel = trans_choice('filament-shop::default.imports.row', $successfulRows);
        $body = '';

        if ($failedRowsCount) {
            $failedRowLabel = trans_choice('filament-shop::default.row', $failedRowsCount);
            $body .= ' ' . __('filament-shop::default.imports.import_failed', [
                'count' => number_format($failedRowsCount),
                'rows' => $failedRowLabel,
            ]);
        } else {
            $body = __('filament-shop::default.imports.import_successful', [
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
