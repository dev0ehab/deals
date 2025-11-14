<?php


namespace Modules\Vendors\Entities\Relations;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Accounts\Entities\Verification;
use Modules\Orders\Entities\Order;

trait VendorRelations
{

    /**
     * Get the Vendor's verification.
     */
    public function verification(): MorphOne
    {
        return $this->morphOne(Verification::class, 'parentable');
    }


}
