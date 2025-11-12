<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUs extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'message',
        'phone',
        'type',
    ];

    protected $dates = [
        'deleted_at',
    ];


    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function getEmailAttribute($value)
    {
        return strtolower($value);
    }

    public function getMessageAttribute($value)
    {
        return ucfirst($value);
    }

    // public function getCreatedAtAttribute($value)
    // {
    //     return time_difference($value);
    // }

}
