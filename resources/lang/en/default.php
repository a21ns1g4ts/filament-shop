<?php

return [
    'navigation_group' => [
        'label' => 'Shop',
    ],

    'exports' => [
        'export_successful' => 'Your brand export has completed and :count :rows exported.',
        'export_failed' => ':count :rows failed to export.',
        'row' => 'row',
        'row_plural' => 'rows',
    ],

    'seo' => [
        'description' => 'Informations that will be used in search engines.',
    ],

    'categories' => [
        'navigation_label' => 'Categories',
        'model_label' => 'Category',
        'plural_model_label' => 'Categories',
        'main' => [
            'name' => [
                'label' => 'Name',
            ],
            'slug' => [
                'label' => 'Slug',
            ],
            'parent' => [
                'label' => 'Parent',
                'placeholder' => 'Select a parent category',
            ],
            'visible' => [
                'label' => 'Visibility',
            ],
            'description' => [
                'label' => 'Description',
            ],
            'created_at' => [
                'label' => 'Created at',
            ],
            'updated_at' => [
                'label' => 'Last modified at',
            ],
        ],
    ],

    'brands' => [
        'navigation_label' => 'Brands',
        'model_label' => 'Brand',
        'plural_model_label' => 'Brands',
        'export_label' => 'Export',
        'export_heading' => 'Export Brands',
        'main' => [
            'name' => [
                'label' => 'Name',
            ],
            'slug' => [
                'label' => 'Slug',
            ],
            'website' => [
                'label' => 'Website',
            ],
            'visible' => [
                'label' => 'Visibility',
            ],
            'description' => [
                'label' => 'Description',
            ],
            'created_at' => [
                'label' => 'Created at',
            ],
            'updated_at' => [
                'label' => 'Last modified at',
            ],
        ],
    ],

    'products' => [
        'navigation_label' => 'Products',
        'model_label' => 'Product',
        'plural_model_label' => 'Products',
        'main' => [
            'name' => [
                'label' => 'Name',
            ],
            'slug' => [
                'label' => 'Slug',
            ],
            'description' => [
                'label' => 'Description',
            ],
            'images' => [
                'label' => 'Images',
            ],
            'created_at' => [
                'label' => 'Created at',
            ],
            'updated_at' => [
                'label' => 'Last modified at',
            ],
        ],

        'pricing' => [
            'label' => 'Pricing',
            'price' => [
                'label' => 'Price',
                'helper_text' => 'The price of the product.',
            ],
            'original_price' => [
                'label' => 'Compare at price',
                'helper_text' => 'The original price of the product.',
            ],
            'cost' => [
                'label' => 'Cost',
                'helper_text' => 'Customers wont see this price.',
            ],
        ],

        'inventory' => [
            'label' => 'Inventory',
            'sku' => [
                'label' => 'SKU',
                'helper_text' => 'The SKU (Stock Keeping Unit) is a unique identifier for the product.',
            ],
            'barcode' => [
                'label' => 'Barcode (ISBN, UPC, GTIN, etc.)',
                'helper_text' => 'The barcode (ISBN, UPC, GTIN, etc.) is commonly used to identify a product and track inventory.',
            ],
            'quantity' => [
                'label' => 'Quantity',
                'helper_text' => 'The quantity of the product available in stock. This not updated automatically for now. You can disable the product if you do not want it to be visible.',
            ],
            'security_stock' => [
                'label' => 'Security stock',
                'helper_text' => 'The safety stock is the limit stock for your products which alerts you if the product stock will soon be out of stock.',
            ],
        ],

        'status' => [
            'label' => 'Status',
            'visible' => [
                'label' => 'Visible',
                'helper_text' => 'This product will be hidden from all sales channels.',
            ],
            'pinned' => [
                'label' => 'Pinned',
                'helper_text' => 'This product will be pinned.',
            ],
            'published_at' => [
                'label' => 'Available on',
                'helper_text' => 'This product will be available from this date.',
            ],
        ],

        'associations' => [
            'label' => 'Associations',
            'categories' => [
                'label' => 'Categories',
                'helper_text' => 'You need select at least one category.',
            ],
            'brand' => [
                'label' => 'Brand',
            ],
        ],

        'meta' => [
            'label' => 'Meta',
        ],

        'widgets' => [
            'stats' => [
                'overview' => [
                    'label' => 'Total products',
                ],
                'quantity' => [
                    'label' => 'Total quantity',
                ],
                'average_price' => [
                    'label' => 'Average price',
                ],
            ],
        ],
    ],
];
