<?php

namespace Modules\Accounts\Repositories;

use Modules\Vendors\Entities\Rate;
use Modules\Vendors\Entities\Vendor;
use Modules\Accounts\Entities\User;
use Modules\Products\Entities\Product;

class RateRepository
{

    public function all()
    {

    }

    /**
     * Save the rate created by the user.
     *
     * @param User $user
     * @param array $data
     * @param int $rateableId
     * @param string $rateableType
     * @return Rate
     */
    public function create(User $user, array $data, int $rateableId, $rateableTypeClass)
    {
        return $user->rates()->updateOrCreate(
            [
                'rateable_id' => $rateableId,
                'rateable_type' => $rateableTypeClass,
            ],
            [
                'value' => $data['value'],
                'comment' => $data['comment'] ?? null,
            ]
        );

    }

    /**
     * Update the rating of a product based on the rateable_id.
     *
     * @param int $productId
     * @param string $rateableType
     * @return void
     */
    public function updateRateableRating(int $rateableId, string $rateableType)
    {
        if ($rateableType == Product::class) {
            $productRate = round(Rate::where('rateable_type', Product::class)
            ->where('rateable_id', $rateableId)
            ->avg('value'), 2);

            Product::where('id', $rateableId)->update(['rate' => $productRate]);

        } elseif ($rateableType == Vendor::class) {
            $vendorRate = round(Rate::where('rateable_type', Vendor::class)
            ->where('rateable_id', $rateableId)
            ->avg('value'), 2);

            Vendor::where('id', $rateableId)->update(['rate' => $vendorRate]);
        }
    }

}
