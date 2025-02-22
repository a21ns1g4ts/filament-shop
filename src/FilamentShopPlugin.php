<?php

namespace A21ns1g4ts\FilamentShop;

use A21ns1g4ts\FilamentShop\Filament\Resources\BrandResource;
use A21ns1g4ts\FilamentShop\Filament\Resources\CategoryResource;
use A21ns1g4ts\FilamentShop\Filament\Resources\ProductResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentShopPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-shop';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            ProductResource::class,
            CategoryResource::class,
            BrandResource::class,
        ]);
    }

    public function boot(Panel $panel): void {}

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
