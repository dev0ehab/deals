<?php

namespace Modules\Accounts\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ResetPasswordToken extends Model
{
    /**
     * the code expiration by seconds.
     *
     * @var int
     */
    const EXPIRE_DURATION = 50 * 60;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parentable_id',
        'parentable_type',
        'token',
    ];

    /**
     * const.
     */
    const UPDATED_AT = null;

    /**
     * Check if this code has been expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->created_at->addSeconds(static::EXPIRE_DURATION)->isPast();
    }

    /**
     * the user who created this token.
     *
     * @return MorphTo
     */
    public function parentable(): MorphTo
    {
        return $this->morphTo();
    }

}
