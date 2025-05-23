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

    'imports' => [
        'import_successful' => 'Sua importação foi concluída com :count :rows importada(s).',
        'import_failed' => ':count :rows falhou/falharam na importação.',
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
        'create_new' => 'Criar nova categoria',
        'notifications' => [
            'cant_delete' => [
                'title' => 'Você não pode excluir esta categoria porque ela possuí produtos associados.',
                'body' => 'Por favor, remova os :count produtos associados antes de excluir esta categoria.',
            ],
        ],
        'main' => [
            'active' => [
                'label' => 'Ativa',
            ],
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
                'label' => 'Atualizado em',
            ],
        ],
    ],

    'brands' => [
        'navigation_label' => 'Marcas',
        'model_label' => 'Marca',
        'create_new' => 'Criar nova marca',
        'plural_model_label' => 'Marcas',
        'export_label' => 'Exportar',
        'export_heading' => 'Exportar Marcas',
        'main' => [
            'active' => [
                'label' => 'Ativa',
            ],
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
                'label' => 'Atualizado em',
            ],
        ],
    ],

    'products' => [
        'navigation_label' => 'Produtos',
        'model_label' => 'Produto',
        'plural_model_label' => 'Produtos',
        'export_label' => 'Exportar',
        'export_heading' => 'Exportar Produtos',
        'import_label' => 'Importar',
        'import_heading' => 'Importar Produtos',
        'main' => [
            'name' => [
                'label' => 'Nome',
            ],
            'price' => [
                'label' => 'Preço',
                'helper_text' => 'O preço do produto.',
            ],
            'slug' => [
                'label' => 'Slug',
            ],
            'description' => [
                'label' => 'Descrição',
            ],
            'images' => [
                'label' => 'Imagens',
                'hint' => 'Adicione no máximo 20 imagens. Até 10MB por imagem.',
            ],
            'created_at' => [
                'label' => 'Criado em',
            ],
            'updated_at' => [
                'label' => 'Atualizado em',
            ],
        ],

        'pricing' => [
            'label' => 'Preço',
            'price' => [
                'label' => 'Preço',
                'helper_text' => 'O preço do produto.',
            ],
            'original_price' => [
                'label' => 'Preço original',
                'helper_text' => 'O preço original do produto. Para restaurar o preço original, clique em "Remover Oferta".',
            ],
            'cost' => [
                'label' => 'Custo',
                'helper_text' => 'Os clientes não verão este preço.',
            ],
            'offer' => [
                'label' => 'Oferta',
                'discount' => 'Desconto',
                'add' => 'Adicionar oferta',
                'new_price' => 'Novo preço',
                'remove' => 'Remover oferta',
                'notifications' => [
                    'added' => [
                        'title' => 'Oferta adicionada com sucesso!',
                        'body' => 'Agora será exibido para os visitantes da loja o preço em oferta do produto com o desconto.',
                    ],
                    'removed' => [
                        'title' => 'Oferta removida com sucesso!',
                        'body' => 'O preço em oferta do produto não será mais exibido para os visitantes da loja.',
                    ],
                ],
            ],
        ],

        'inventory' => [
            'label' => 'Inventário',
            'sku' => [
                'label' => 'SKU',
                'helper_text' => 'O SKU (Unidade de estoque) é um identificador exclusivo para o produto.',
            ],
            'barcode' => [
                'label' => 'Código de barras (ISBN, UPC, GTIN, etc.)',
                'helper_text' => 'O código de barras (ISBN, UPC, GTIN, etc.) é usualmente usado para identificar um produto e rastrear o estoque.',
            ],
            'quantity' => [
                'label' => 'Quantidade',
                'helper_text' => 'A quantidade do produto em estoque. Este valor não é atualizado automaticamente. Você pode desativar o produto se não quiser que ele seja visualizado.',
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
                'helper_text' => 'Altere a visibilidade do produto. Quando desativado, o produto será ocultado da loja.',
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
                'helper_text' => 'Você precisa selecionar pelo menos uma categoria. Se você não encontrar a categoria desejada, clique em "+" para adicionar uma nova.',
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

    'common' => [
        'create' => 'Criar',
    ],
];
