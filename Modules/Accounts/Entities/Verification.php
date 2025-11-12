<?php

namespace Modules\Accounts\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Verification extends Model
{
    use HasFactory;

    /**
     * the code expiration by seconds.
     *
     * @var int
     */
    const EXPIRE_DURATION = 10 * 60;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'code',
        'parentable_id',
        'parentable_type',
        'updated_at',
    ];

    public function parentable() : MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Determine whither the verification code is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->updated_at->addMinutes(5)->isPast();
    }
}
