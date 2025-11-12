<?php

namespace Modules\Services\Entities;

use App\Http\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Services\Entities\Scopes\ServiceScopes;
use Modules\Support\Traits\MediaTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service extends Model implements HasMedia
{
    use HasFactory, Translatable, Filterable, MediaTrait, ServiceScopes,
        InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        "price"
    ];

    protected $table = 'services';

    public $translatedAttributes = ['name', 'title', 'description'];

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
        $this->addMediaCollection('covers');
    }


    public function getCoverAttribute()
    {
        return $this->getFirstMediaUrl('covers');
    }


    public function getImagesAttribute()
    {
        return $this->getMediaResource('images');
    }




}
