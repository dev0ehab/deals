<?php

namespace Modules\Attributes\Entities;

use App\Enums\AttributePricingEnum;
use App\Http\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Attributes\Entities\Relations\AttributeOptionRelations;
use Modules\Attributes\Entities\Scopes\AttributeOptionScopes;
use Modules\Support\Traits\MediaTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AttributeOption extends Model implements HasMedia
{
    use Translatable,
        Filterable,
        HasFactory,
        MediaTrait,
        AttributeOptionRelations,
        AttributeOptionScopes,
        InteractsWithMedia;

    /**
     * @var array
     */
    public $translatedAttributes = ['name'];


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
        $this->addMediaCollection('icons');
    }

    public function getImageAttribute()
    {
        return $this->getMediaResource('images')[0] ??= null;
    }

    public function getImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('images');
    }
    public function getIconAttribute()
    {
        return $this->getMediaResource('icons')[0] ??= null;
    }

    public function getIconUrlAttribute()
    {
        return $this->getFirstMediaUrl('icons');
    }

    public function getAttributeTypeAttribute()
    {
        return $this->attribute->pricing_type;
    }

    /**
     * @var array
     */
    protected $with = [
        'translations',
        'media',
    ];

    protected $fillable = [
        'attribute_id',
        'is_default',
        'paper_count_factor',
        'price',
    ];

    protected $casts = [
        'is_default'         => 'boolean',
        'paper_count_factor' => 'float',
        'price'              => 'float',
    ];


    public static function boot()
    {
        parent::boot();

        self::deleted(function ($attributeOption) {
            if($attributeOption->attribute->pricing_type == AttributePricingEnum::PAPER_PRICE->value) {
            $attributeOption->removeFromMatrix();
            }
        });

    }

    public function removeFromMatrix()
    {
        PricingMatrix::where('key', 'like', '%-'.$this->id.'-%')
        ->orwhere('key', 'startsWith', $this->id.'-')
        ->orwhere('key', 'endsWith', '-'.$this->id)
        ->delete();
    }

    public function isInPriceMatrix()
    {
        if($this->attribute->pricing_type == AttributePricingEnum::PAPER_PRICE->value) {
            return in_array($this->id, PricingMatrix::matrixedOptions());
        }

        return true;
    }
}
