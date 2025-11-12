<?php


namespace Modules\Addresses\Entities\Relations;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Accounts\Entities\User;

trait AddressRelations
{
    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
