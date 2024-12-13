<?php

namespace A21ns1g4ts\FilamentShop;

class FilamentShop {
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
}
