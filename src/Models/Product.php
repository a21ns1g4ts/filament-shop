<?php

namespace A21ns1g4ts\FilamentShop\Models;

use A21ns1g4ts\FilamentShop\Database\Factories\ProductFactory;
use A21ns1g4ts\FilamentShop\FilamentShop;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory;
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
        'qty',
        'security_stock',
        'featured',
        'visible',
        'old_price',
        'price',
        'cost',
        'type',
        'backorder',
        'requires_shipping',
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
        'featured' => 'boolean',
        'visible' => 'boolean',
        'backorder' => 'boolean',
        'requires_shipping' => 'boolean',
        'published_at' => 'date',
    ];

    protected static $factory = ProductFactory::class;

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
