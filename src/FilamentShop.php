<?php

namespace A21ns1g4ts\FilamentShop;

class FilamentShop
{
    public static function getProductModel(): string
    {
        return config('filament-shop.products.model');
    }

    public static function getBrandModel(): string
    {
        return config('filament-shop.brands.model');
    }

    public static function getCategoryModel(): string
    {
        return config('filament-shop.categories.model');
    }

    public static function getDecimalSeparator(): string
    {
        return config('filament-shop.decimal_separator');
    }

    public static function getThousandSeparator(): string
    {
        return config('filament-shop.thousand_separator');
    }

    public static function getCurrency(): string
    {
        return config('filament-shop.currency');
    }

    public static function getDecimalPrecision(): int
    {
        return config('filament-shop.decimal_precision');
    }
}
