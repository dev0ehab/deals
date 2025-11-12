<?php

namespace Modules\Payments\Entities;

use App\Http\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Payments\Database\factories\PaymentFactory;
use Modules\Payments\Entities\Helpers\PaymentHelpers;
use Modules\Payments\Entities\Relations\PaymentRelations;
use Modules\Payments\Entities\Scopes\PaymentScopes;
use Modules\Support\Traits\MediaTrait;
use Modules\Support\Traits\Selectable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Payment extends Model implements HasMedia
{
    use Translatable,
        Filterable,
        Selectable,
        HasFactory,
        PaymentHelpers,
        MediaTrait,
        PaymentRelations,
        PaymentScopes,
        InteractsWithMedia;

    /**
     * @var array
     */
    public $translatedAttributes = ['name'];

    /**
     * @var array
     */
    protected $fillable = [
        'active',
        'created_at',
        'updated_at',
    ];

    /**
     * @var array
     */
    protected $with = [
        'translations',
    ];


    /**
     * @var string[]
     */
    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory()
    {
        return PaymentFactory::new();
    }

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

    /**
     * The VendorCategory image url.
     *
     * @return bool
     */
    public function getImage()
    {
        return $this->getFirstMediaUrl('images');
    }
}
