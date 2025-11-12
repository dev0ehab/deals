<?php

namespace Modules\Features\Entities;

use App\Http\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Features\Entities\Scopes\FeatureScopes;
use Modules\Support\Traits\Selectable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Feature extends Model implements HasMedia
{
    use HasFactory, Translatable, Filterable, Selectable,  InteractsWithMedia, FeatureScopes;

    protected $fillable = ['rank'];
    protected $table = 'features';

    public $translatedAttributes = ['name', 'description', 'brief'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'translations',
        'media',
    ];


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


    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('images');
    }

    public function getCoverAttribute()
    {
        return $this->getFirstMediaUrl('covers');
    }


    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get all of the subFeatures for the Feature
     *
     * @return HasMany
     */
    public function subFeatures(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Get all of the subFeatures for the Feature
     *
     * @return HasMany
     */
    public function options(): HasMany
    {
        return $this->hasMany(FeatureOption::class , 'feature_id');
    }


}
