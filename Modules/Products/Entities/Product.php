<?php

namespace Modules\Products\Entities;

use App\Http\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Orders\Entities\Order;
use Modules\Orders\Entities\OrderProduct;
use Modules\Products\Entities\ProductFeature;
use Modules\Sections\Entities\Section;
use Modules\Support\Traits\MediaTrait;
use Modules\Support\Traits\Selectable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory,
        Translatable,
        Filterable,
        MediaTrait,
        SoftDeletes,
        Selectable,
        InteractsWithMedia;

    protected $fillable = [
        'price',
        'old_price',
        'stock',
        'section_id',
        'rank',
        'is_active',
        'rate',
    ];


    protected $table = 'products';

    public $translatedAttributes = ['name', 'description'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'translations',
        'media',
        'section',
    ];

    /**
     * Define the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
        $this->addMediaCollection('covers');
    }

    /**
     * The product cover url.
     *
     */
    public function getCoverAttribute()
    {
        return $this->getFirstMediaUrl('covers');
    }


    public function getImagesAttribute()
    {
        return $this->getMediaResource('images');
    }


    /**
     * Get the service that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }


    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')
                    ->withPivot('quantity', 'price','total');
    }


    public function isActive()
    {
        return $this->is_active == 1;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function features()
    {
        return $this->hasMany(ProductFeature::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function getRatesAttribute()
    {
        return $this->orderProducts()->inRandomOrder()->with('order.user')->where('rate', '!=', null)->where('is_rate_accepted', 1)->take(5)->get();
    }

    public function getRatesCountAttribute()
    {
        return $this->orderProducts()->where('rate', '!=', null)->where('is_rate_accepted', 1)->count();
    }
}
