<?php

namespace A21ns1g4ts\FilamentShop\Models;

use A21ns1g4ts\FilamentShop\Database\Factories\BrandFactory;
use A21ns1g4ts\FilamentShop\FilamentShop;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Brand extends Model implements HasMedia
{
    use HasFactory;
    use HasSEO;
    use InteractsWithMedia;

    /**
     * @var string
     */
    protected $table = 'filament_shop_brands';

    protected $fillable = [
        'name',
        'slug',
        'website',
        'description',
        'active',
        'visible',
        'sort',
        'seo_title',
        'seo_description',
        'sort',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'active' => 'boolean',
        'visible' => 'boolean',
    ];

    protected static function newFactory()
    {
        return BrandFactory::new();
    }

    /** @return HasMany<Product> */
    public function products(): HasMany
    {
        return $this->hasMany(FilamentShop::getProductModel(), 'brand_id');
    }
}
