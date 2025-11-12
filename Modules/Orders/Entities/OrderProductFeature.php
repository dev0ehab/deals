<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Features\Entities\FeatureOption;
use Modules\Products\Entities\ProductFeatureOption;
use Modules\Products\Entities\ProductFeature;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Support\Traits\MediaTrait;

class OrderProductFeature extends Model implements HasMedia
{
    use HasFactory,
        MediaTrait,
        InteractsWithMedia;

    protected $table = 'order_product_features'; // optional, or just use default

    protected $fillable = [
        'order_product_id',
        'product_feature_id',
        'feature_option_id',
        'option',
    ];


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
    }

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('images');
    }
    protected $casts = [
        'option' => 'string',
    ];

    public function productFeature()
    {
        return $this->belongsTo(ProductFeature::class);
    }

    public function featureOption()
    {
        return $this->belongsTo(FeatureOption::class);
    }

    public function getOptionProductAttribute()
    {
        return $this->featureOption?->name ?? $this->option;
    }
}
