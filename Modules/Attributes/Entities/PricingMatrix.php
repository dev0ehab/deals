<?php

namespace Modules\Attributes\Entities;

use Illuminate\Database\Eloquent\Model;
class PricingMatrix extends Model
{

    /**
     * @var string[]
     */
    protected $fillable = [
        'key',
        'value',
    ];


    protected $table = 'pricing_matrix';

    /**
     * @var array
     */
    protected $casts = [
        'value' => 'float',
    ];


    public static function matrixedAttributes()
    {
        // explode the key into array the get the attribute_id from options table
        $option_ids = self::matrixedOptions();

        return Attribute::whereHas('options', function ($query) use ($option_ids) {
            $query->whereIn('id', $option_ids);
        })->pluck('id')->toArray();

    }

    public static function matrixedOptions()
    {
        $matrixed_keys = self::pluck('key')->toArray();
        $matrixed_options = [];
        foreach ($matrixed_keys as $key) {
            $matrixed_options = array_merge($matrixed_options, explode('-', $key));
        }
        return array_unique($matrixed_options);

    }
}
