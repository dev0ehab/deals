<?php

namespace Modules\Accounts\Entities;

use App\Http\Filters\Filterable;
use App\Models\Otp;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Laracasts\Presenter\PresentableTrait;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Sanctum\HasApiTokens;
use Modules\Accounts\Entities\Helpers\UserHelpers;
use Modules\Accounts\Entities\Presenters\UserPresenter;
use Modules\Accounts\Entities\Relations\UserRelations;
use Modules\Accounts\Entities\Scopes\UserScopes;
use Modules\Accounts\Transformers\CustomerResource;
use Modules\Support\Traits\Favorable;
use Modules\Support\Traits\MediaTrait;
use Modules\Support\Traits\Selectable;
use Parental\HasChildren;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia, HasLocalePreference
{
    use Notifiable,
        UserHelpers,
        UserScopes,
        HasChildren,
        HasApiTokens,
        PresentableTrait,
        MediaTrait,
        InteractsWithMedia,
        Filterable,
        LaratrustUserTrait,
        SoftDeletes,
        Selectable,
        UserRelations,
        // Favorable,
        HasFactory,
        Impersonate;

    /**
     * Get the user's preferred locale.
     *
     * @return string
     */
    public function preferredLocale(): string
    {
        return $this->preferred_locale ?? app()->getLocale();
    }

    /**
     * The code of admin type.
     *
     * @var string
     */
    public const ADMIN_TYPE = 'admin';

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
        'order_notification',
        'location',
        'lat',
        'balance',
        'long',
        'phone_verified_at',
        'email_verified_at',
        'belongs_to_vendor',
        'vendor_id',
        'facebook_id',
        'google_id',
        'apple_id',
    ];

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
     * @var array
     */
    protected array $childTypes = [
        self::ADMIN_TYPE => Admin::class,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
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
     * The presenter class name.
     *
     * @var string
     */
    protected string $presenter = UserPresenter::class;

    /**
     * Get the number of models to return per page.
     *
     */
    public function getPerPage()
    {
        return request('perPage', parent::getPerPage());
    }

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

    /**
     * Get the resource for customer type.
     *
     * @return CustomerResource
     */
    public function getResource()
    {
        return new CustomerResource($this);
    }

    /**
     * Get the access token currently associated with the user. Create a new.
     *
     * @param string|null $device
     * @return string
     */
    public function createTokenForDevice($device = null): string
    {
        $device = $device ?: 'Unknown Device';

        if ($this->currentAccessToken()) {
            return $this->currentAccessToken()->token;
        }

        $this->tokens()->where('name', $device)->delete();

        return $this->createToken($device)->plainTextToken;
    }

    public function routeNotificationForOneSignal()
    {
        return $this->device_token;
    }

    /**
     * Determine whither the user can impersonate another user.
     *
     * @return bool
     */
    public function canImpersonate(): bool
    {
        return $this->hasRole('super_admin');
    }

    /**
     * Determine whither the user can be impersonated by the admin.
     *
     * @return bool
     */
    public function canBeImpersonated(): bool
    {
        return $this->can_access;
    }

    public function otps()
    {
        return $this->morphMany(Otp::class, 'user');
    }
    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->last_name;
    }

    protected function getAvatarAttribute()
    {
        return $this->getFirstMediaUrl('avatars') ? asset($this->getFirstMediaUrl('avatars')) : asset('/images/user.png');
    }


    protected static function boot()
    {
        parent::boot();

        self::saving(function ($model) {
            if (request()->has('f_name')) {
                $model->name = request('f_name');
            }
        });
    }
}
