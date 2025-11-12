<?php


namespace Modules\Attributes\Entities\Scopes;

use App\Enums\AttributePricingEnum;
use Modules\Attributes\Entities\PricingMatrix;


trait AttributeScopes
{
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInPriceMatrix($query)
    {
        return $query->where(function ($q) {
            $q->where('pricing_type', AttributePricingEnum::PAPER_PRICE->value)->whereIn('id', PricingMatrix::matrixedAttributes());
        })->orWhere('pricing_type', "!=", AttributePricingEnum::PAPER_PRICE->value);
    }
}
