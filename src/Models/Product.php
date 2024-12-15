<?php

namespace A21ns1g4ts\FilamentShop\Models;

use A21ns1g4ts\FilamentShop\Database\Factories\ProductFactory;
use A21ns1g4ts\FilamentShop\FilamentShop;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use HasSEO;
    use InteractsWithMedia;

    /**
     * @var string
     */
    protected $table = 'filament_shop_products';

    protected $fillable = [
        'name',
        'meta',
        'slug',
        'sku',
        'barcode',
        'description',
        'quantity',
        'security_stock',
        'pinned',
        'visible',
        'original_price',
        'price',
        'cost',
        'type',
        'published_at',
        'seo_title',
        'seo_description',
        'weight_value',
        'weight_unit',
        'height_value',
        'height_unit',
        'width_value',
        'width_unit',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'meta' => 'array',
        'pinned' => 'boolean',
        'visible' => 'boolean',
        'published_at' => 'date',
    ];

    protected static function newFactory()
    {
        return ProductFactory::new();
    }

    /** @return BelongsTo<Brand,self> */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(FilamentShop::getBrandModel(), 'brand_id');
    }

    /** @return BelongsToMany<Category> */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(FilamentShop::getCategoryModel(), 'filament_shop_category_product', 'product_id', 'category_id')->withTimestamps();
    }
}
