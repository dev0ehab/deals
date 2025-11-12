<?php

namespace Modules\Advertisements\Entities;

use App\Http\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Advertisements\Entities\Helpers\AdvertisementHelpers;
use Modules\Advertisements\Entities\Relations\AdvertisementRelations;
use Modules\Advertisements\Entities\Scopes\AdvertisementScopes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Advertisement extends Model implements HasMedia
{
    use
        HasFactory,
        Translatable,
        Filterable,
        InteractsWithMedia,
        AdvertisementHelpers,
        AdvertisementScopes,
        AdvertisementRelations;

    protected $fillable = [
        'url',
        'active'
    ];

    protected $table = 'advertisements';

    public $translatedAttributes = ['title'];

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
        $this->addMediaCollection('images');
    }

}
