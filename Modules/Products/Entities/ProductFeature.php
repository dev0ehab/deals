<?php

namespace Modules\Products\Entities;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Support\Traits\MediaTrait;
use Modules\Support\Traits\Selectable;
use Modules\Features\Entities\Feature;
use Modules\Features\Entities\FeatureOption;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ProductFeature extends Model implements HasMedia
{
    use HasFactory,
        Filterable,
        MediaTrait,
        Selectable,
        InteractsWithMedia;

    protected $fillable = [
        'is_active',
        'product_id',
        'attribute_id',
        'feature_type',
        'text_ar',
        'text_en',
        'text_value_ar',
        'text_value_en',
        'feature_id',
    ];

    protected $table = 'product_features';

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'media',
    ];

    /**
     * Define the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
    }


    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('images');
    }

    public function isActive()
    {
        return $this->is_active == 1;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }

    public function featureOptions()
    {
        return $this->belongsToMany(FeatureOption::class, 'product_feature_options', 'product_feature_id', 'feature_option_id');
    }
}


