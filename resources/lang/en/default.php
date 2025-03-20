<?php

return [
    'navigation_group' => [
        'label' => 'Shop',
    ],

    'exports' => [
        'export_successful' => 'Your export has completed and :count :rows exported.',
        'export_failed' => ':count :rows failed to export.',
        'row' => 'row',
        'row_plural' => 'rows',
    ],

    'imports' => [
        'import_successful' => 'Your import has completed and :count :rows imported.',
        'import_failed' => ':count :rows failed to import.',
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
        'create_new' => 'Create new category',
        'notifications' => [
            'cant_delete' => [
                'title' => 'You can not delete this category because it has associated products.',
                'body' => 'Please remove the :count associated products before deleting this category.',
            ],
        ],
        'main' => [
            'active' => [
                'label' => 'Active',
            ],
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
        'create_new' => 'Create new brand',
        'plural_model_label' => 'Brands',
        'export_label' => 'Export',
        'export_heading' => 'Export Brands',
        'main' => [
            'active' => [
                'label' => 'Active',
            ],
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
        'export_label' => 'Export',
        'export_heading' => 'Export Products',
        'import_label' => 'Import',
        'import_heading' => 'Import Products',
        'main' => [
            'name' => [
                'label' => 'Name',
            ],
            'price' => [
                'label' => 'Price',
                'helper_text' => 'The price of the product.',
            ],
            'slug' => [
                'label' => 'Slug',
            ],
            'description' => [
                'label' => 'Description',
            ],
            'images' => [
                'label' => 'Images',
                'hint' => 'Add no more than 20 images. Up to 10MB per image.',
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
                'label' => 'Original price',
                'helper_text' => 'The original price of the product.',
            ],
            'cost' => [
                'label' => 'Cost',
                'helper_text' => 'Customers wont see this price.',
            ],
            'offer' => [
                'label' => 'Offer',
                'discount' => 'Discount',
                'add' => 'Add offer',
                'new_price' => 'New price',
                'remove' => 'Remove offer',
                'notifications' => [
                    'added' => [
                        'title' => 'Offer added successfully!',
                        'body' => 'The discounted product price will now be displayed to store visitors.',
                    ],
                    'removed' => [
                        'title' => 'Offer removed successfully!',
                        'body' => 'The discounted product price will no longer be displayed to store visitors.',
                    ],
                ],
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
                'helper_text' => 'You need select at least one category. If you don\'t find the category you want, click "+" to add a new one.',
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

    'common' => [
        'create' => 'Create',
    ],
];
