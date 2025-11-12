<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AboutUs extends Model
{
    use HasFactory;

    protected $fillable = [
        'about_us_title',
        'about_us_sub_title',
        'about_us_desc',
        'our_vision',
        'our_mission',
        'our_tasks',
        'address',
        'map_address1',
        'longitude1',
        'latitude1',
        'map_address2',
        'longitude2',
        'latitude2',
    ];

    protected $table = 'about_us';

}
