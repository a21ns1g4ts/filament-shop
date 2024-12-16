<?php

return [
    'navigation_group' => [
        'label' => 'Loja',
    ],

    'exports' => [
        'export_successful' => 'Sua exportação foi concluída com :count :rows exportada(s).',
        'export_failed' => ':count :rows falhou/falharam na exportação.',
        'row' => 'linha',
        'row_plural' => 'linhas',
    ],

    'seo' => [
        'description' => 'Informações que serão usadas nos motores de busca.',
    ],

    'categories' => [
        'navigation_label' => 'Categorias',
        'model_label' => 'Categoria',
        'plural_model_label' => 'Categorias',
        'main' => [
            'name' => [
                'label' => 'Nome',
            ],
            'slug' => [
                'label' => 'Slug',
            ],
            'parent' => [
                'label' => 'Categoria Pai',
                'placeholder' => 'Selecione uma categoria pai',
            ],
            'visible' => [
                'label' => 'Visibilidade',
            ],
            'description' => [
                'label' => 'Descrição',
            ],
            'created_at' => [
                'label' => 'Criado em',
            ],
            'updated_at' => [
                'label' => 'Última modificação em',
            ],
        ],
    ],

    'brands' => [
        'navigation_label' => 'Marcas',
        'model_label' => 'Marca',
        'plural_model_label' => 'Marcas',
        'export_label' => 'Exportar',
        'export_heading' => 'Exportar Marcas',
        'main' => [
            'name' => [
                'label' => 'Nome',
            ],
            'slug' => [
                'label' => 'Slug',
            ],
            'website' => [
                'label' => 'Website',
            ],
            'visible' => [
                'label' => 'Visibilidade',
            ],
            'description' => [
                'label' => 'Descrição',
            ],
            'created_at' => [
                'label' => 'Criado em',
            ],
            'updated_at' => [
                'label' => 'Última modificação em',
            ],
        ],
    ],

    'products' => [
        'navigation_label' => 'Produtos',
        'model_label' => 'Produto',
        'plural_model_label' => 'Produtos',
        'main' => [
            'name' => [
                'label' => 'Nome',
            ],
            'slug' => [
                'label' => 'Slug',
            ],
            'description' => [
                'label' => 'Descrição',
            ],
            'images' => [
                'label' => 'Imagens',
            ],
        ],

        'pricing' => [
            'label' => 'Preço',
            'description' => 'Informações de preço do produto.',
            'price' => [
                'label' => 'Preço',
                'helper_text' => 'O preço do produto.',
            ],
            'original_price' => [
                'label' => 'Preço de comparação',
                'helper_text' => 'O preço original do produto.',
            ],
            'cost' => [
                'label' => 'Custo',
                'helper_text' => 'Os clientes não verão este preço.',
            ],
        ],

        'inventory' => [
            'label' => 'Estoque',
            'sku' => [
                'label' => 'SKU (Stock Keeping Unit)',
            ],
            'barcode' => [
                'label' => 'Código de barras (ISBN, UPC, GTIN, etc.)',
            ],
            'quantity' => [
                'label' => 'Quantidade',
            ],
            'security_stock' => [
                'label' => 'Estoque de segurança',
                'helper_text' => 'O estoque de segurança é o limite de estoque para seus produtos que alerta você se o estoque do produto estará em breve esgotado.',
            ],
        ],

        'status' => [
            'label' => 'Status',
            'visible' => [
                'label' => 'Visível',
                'helper_text' => 'Este produto será ocultado de todos os canais de vendas.',
            ],
            'pinned' => [
                'label' => 'Fixado',
                'helper_text' => 'Este produto será fixado.',
            ],
            'published_at' => [
                'label' => 'Disponível em',
                'helper_text' => 'Este produto estará disponível a partir desta data.',
            ],
        ],

        'associations' => [
            'label' => 'Associações',
            'categories' => [
                'label' => 'Categorias',
                'helper_text' => 'Você precisa selecionar pelo menos uma categoria.',
            ],
            'brand' => [
                'label' => 'Marca',
            ],
        ],

        'meta' => [
            'label' => 'Meta',
        ],

        'widgets' => [
            'stats' => [
                'overview' => [
                    'label' => 'Total de produtos',
                ],
                'quantity' => [
                    'label' => 'Quantidade total',
                ],
                'average_price' => [
                    'label' => 'Preço médio',
                ],
            ],
        ],
    ],
];
