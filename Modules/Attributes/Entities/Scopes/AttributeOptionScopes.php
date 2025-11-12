<?php


namespace Modules\Attributes\Entities\Scopes;

use App\Enums\AttributePricingEnum;
use Modules\Attributes\Entities\PricingMatrix;
trait AttributeOptionScopes
{

    public function scopeInPriceMatrix($query)
    {
        return $query->where(function ($q) {
            $q->whereIn('id', PricingMatrix::matrixedOptions())->whereHas('attribute', function ($q) {
                $q->where('pricing_type', AttributePricingEnum::PAPER_PRICE->value);
            });
        })
            ->orWhereHas('attribute', function ($q) {
                $q->where('pricing_type', "!=", AttributePricingEnum::PAPER_PRICE->value);
            });
    }
}
