<?php

namespace Modules\Attributes\Entities;

use App\Http\Filters\Filterable;
use App\Enums\AttributePricingEnum;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Attributes\Entities\Relations\AttributeRelations;
use Modules\Attributes\Entities\Scopes\AttributeScopes;
use Modules\Support\Traits\Selectable;

class Attribute extends Model
{
    use Translatable,
        Filterable,
        Selectable,
        HasFactory,
        AttributeRelations,
        AttributeScopes;


    /**
     * @var array
     */
    public $translatedAttributes = ['title', 'description'];

    /**
     * @var array
     */
    protected $with = [
        'translations',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'type',
        'pricing_type',
        'price',
        'is_active',
        'rank',
        'category_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     *
     * @return bool
     */
    public function isActive()
    {
        if ($this->is_active == 1) {
            return true;
        }
        return false;
    }

    public static function boot()
    {
        parent::boot();


        self::deleted(function ($attribute) {
            if ($attribute->pricing_type == AttributePricingEnum::PAPER_PRICE->value) {
                $attribute->removeFromMatrix();
            }
        });

        self::saving(function ($attribute) {
            if ($attribute->isDirty('is_active') && $attribute->is_active == 0  && $attribute->pricing_type == AttributePricingEnum::PAPER_PRICE->value) {
                $attribute->removeFromMatrix();
            }
        });

    }

    public function removeFromMatrix()
    {
        $matrix_entries = PricingMatrix::pluck('value', 'key')->toArray();

        $attribute_options = $this->options->pluck('id')->toArray();

        $new_matrix = [];
        foreach ($matrix_entries as $key => $value) {

            // explode the key into array then remove the attribute_options from the array the implode it again
            $new_key = implode('-', array_diff(explode('-', $key), $attribute_options));

            $new_matrix[] = [
                'key' => $new_key,
                'value' => $value,
            ];
        }

        PricingMatrix::truncate();
        PricingMatrix::insert($new_matrix);

    }


    public function isInPriceMatrix()
    {
        if($this->pricing_type == AttributePricingEnum::PAPER_PRICE->value) {
            return in_array($this->id, PricingMatrix::matrixedAttributes());
        }

        return true;
    }


}
