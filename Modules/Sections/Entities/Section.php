<?php

namespace Modules\Sections\Entities;

use App\Http\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Products\Entities\Product;

class Section extends Model implements HasMedia
{
    use  Translatable , Filterable , SoftDeletes, HasFactory, InteractsWithMedia;

    protected $fillable = [
        'created_at',
        'updated_at'
    ];

    protected $table = 'sections';

    public $translatedAttributes = ['name'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'translations',
        'media',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
    }

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('images');
    }
    
    public function getImage()
    {
        return $this->getFirstMediaUrl('images');
    }


    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
