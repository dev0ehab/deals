<?php

namespace Modules\Addresses\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Addresses\Database\factories\AddressFactory;
use Modules\Addresses\Entities\Relations\AddressRelations;
use Modules\Addresses\Entities\Scopes\AddressScopes;
use Modules\Addresses\Transformers\AddressesResource;
use Modules\Areas\Entities\Area;

class Address extends Model
{
    use HasFactory, AddressRelations, AddressScopes, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'building_number',
        'appartement_number',
        'floor_number',
        'street_name',
        'area_id',
        'landmark',
        'address',
        'area',
        'lat',
        'long',
        'type',
        'is_default',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Address $address) {
            self::where('user_id', $address->user->id)->where('is_default', 1)->update(
                [
                    "is_default" => 0
                ]
            );

            $address->is_default = 1;
        });
    }


    public function areaModel()
    {
        return $this->belongsTo(Area::class , 'area_id');
    }

    /**
     * Get the resource for address.
     *
     * @return AddressesResource
     */
    public function getResource()
    {
        return new AddressesResource($this);
    }


    public function getDeliveryPriceAttribute()
    {
        return deliveryPrice($this->lat, $this->long);
    }

}
