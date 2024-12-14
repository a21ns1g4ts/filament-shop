<?php

return [
    'navigation_group' => [
        'label' => 'Shop',
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
        ]
    ],

    'brands' => [
        'navigation_label' => 'Brands',
        'model_label' => 'Brand',
        'plural_model_label' => 'Brands',
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
            ]
        ]
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
        ],

        'pricing' => [
            'label' => 'Pricing',
            'description' => 'Pricing information for the product.',
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
                'label' => 'SKU (Stock Keeping Unit)',
            ],
            'barcode' => [
                'label' => 'Barcode (ISBN, UPC, GTIN, etc.)',
            ],
            'quantity' => [
                'label' => 'Quantity',
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
            ]
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
        ]
    ]
];
