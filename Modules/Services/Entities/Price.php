<?php

namespace Modules\Services\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Products\Entities\Product;
use Modules\Offers\Entities\Offerproduct;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'price',
        'express_price',
    ];

    /**
     * Get the product that owns the Price
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }



}
