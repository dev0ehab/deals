<?php

namespace Modules\Vendors\Entities;

use App\Http\Filters\Filterable;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Vendors\Entities\Helpers\VendorHelpers;
use Modules\Vendors\Entities\Relations\VendorRelations;
use Modules\Vendors\Entities\Scopes\VendorScopes;
use Spatie\MediaLibrary\InteractsWithMedia;

class Vendor extends Authenticatable implements HasMedia, HasLocalePreference
{
    use Notifiable,
        HasApiTokens,
        VendorScopes,
        VendorHelpers,
        VendorRelations,
        InteractsWithMedia,
        Filterable,
        SoftDeletes,
        HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'l_name',
        'email',
        'phone',
        'password',
        'remember_token',
        'blocked_at',
        'last_login_at',
        'device_token',
        'preferred_locale',
        'phone_verified_at',
        'email_verified_at',
        'location',
        'lat',
        'long',
        'balance',
        'order_notification',
        'facebook_id',
        'google_id',
        'apple_id',
    ];


    protected $guard = "vendor";


    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['media'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'phone_verified_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'blocked_at',
        'last_login_at',
    ];


    /**
     * Define the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatars')
        ->useFallbackUrl('https://www.gravatar.com/avatar/' . md5($this->email) . '?d=mm')
            ->singleFile();
    }
}
