<?php

namespace A21ns1g4ts\FilamentShop\Models;

use A21ns1g4ts\FilamentShop\Database\Factories\ProductFactory;
use A21ns1g4ts\FilamentShop\FilamentShop;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
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
        'published_at',
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

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $baseSlug = Str::slug($model->name);
            $slug = $baseSlug;
            $count = 2;

            while (static::where('slug', $slug)->where('id', '!=', $model->id)->exists()) {
                $slug = $baseSlug . '-' . $count;
                $count++;
            }

            $model->slug = $slug;
        });
    }

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

    protected function off(): Attribute
    {
        return Attribute::make(
            get: fn () => isset($this->original_price) && $this->original_price > 0
                ? round((($this->original_price - $this->price) / $this->original_price) * 100, 2)
                : null
        );
    }
}
