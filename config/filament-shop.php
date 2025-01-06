<?php

return [
    'tenant_scope' => false,
    'navigation_group' => true,
    'products' => [
        'model' => \A21ns1g4ts\FilamentShop\Models\Product::class,
    ],
    'brands' => [
        'model' => \A21ns1g4ts\FilamentShop\Models\Brand::class,
    ],
    'categories' => [
        'model' => \A21ns1g4ts\FilamentShop\Models\Category::class,
    ],

    'decimal_separator' => ',',
    'thousand_separator' => '.',
    'currency' => 'USD',
    'decimal_precision' => 2,
];
