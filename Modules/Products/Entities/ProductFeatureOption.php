<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Features\Entities\FeatureOption;

class ProductFeatureOption extends Model
{

    protected $fillable = [
        'feature_option_id',
        'product_feature_id',
    ];

    protected $table = 'product_feature_options';


    public function featureOption(): BelongsTo
    {
        return $this->belongsTo(FeatureOption::class, 'feature_option_id');
    }


    public function productFeature(): BelongsTo
    {
        return $this->belongsTo(ProductFeature::class, 'product_feature_id');
    }
}


