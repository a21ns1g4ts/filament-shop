<?php

namespace A21ns1g4ts\FilamentShop\Models;

use A21ns1g4ts\FilamentShop\Database\Factories\CategoryFactory;
use A21ns1g4ts\FilamentShop\FilamentShop;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    use HasFactory;
    use HasSEO;
    use InteractsWithMedia;

    /**
     * @var string
     */
    protected $table = 'filament_shop_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'active',
        'visible',
        'sort',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'active' => 'boolean',
        'visible' => 'boolean',
        'sort' => 'integer',
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
        return CategoryFactory::new();
    }

    /** @return HasMany<Category> */
    public function children(): HasMany
    {
        return $this->hasMany(FilamentShop::getCategoryModel(), 'parent_id');
    }

    /** @return BelongsTo<Category,self> */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(FilamentShop::getCategoryModel(), 'parent_id');
    }

    /** @return BelongsToMany<Product> */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(FilamentShop::getProductModel(), 'filament_shop_category_product', 'category_id', 'product_id');
    }
}
