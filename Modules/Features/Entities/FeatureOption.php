<?php

namespace Modules\Features\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class FeatureOption extends Model implements HasMedia
{
    use Translatable,  InteractsWithMedia;

    protected $fillable = ['feature_id'];
    public $translatedAttributes = ['name', 'description'];
    protected $table = 'feature_options';


    /**
     * Define the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->useFallbackUrl('https://cdn.shopify.com/s/files/1/0422/0194/0126/products/CombinePhotos_800x.png?v=1633998941');
    }


    public function getImage()
    {
        return $this->getFirstMediaUrl('images');
    }

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('images');
    }


    /**
     * Get the feature that owns the FeatureOption
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feature(): BelongsTo
    {
        return $this->belongsTo(Feature::class);
    }

    
}
