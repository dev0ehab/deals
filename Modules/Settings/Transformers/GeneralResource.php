<?php

namespace Modules\Settings\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Laraeast\LaravelSettings\Facades\Settings;

class GeneralResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => Settings::get('name:' . app()->getLocale()),
            'description' => Settings::locale(app()->getLocale())->get('description'),
            'logo' => app_logo(),
            'latitude' => Settings::get('latitude'),
            'longitude' => Settings::get('longitude'),
            "unreadNotificationsCount" => user() ? user()->unreadNotifications()->count() : 0,
        ];
    }
}
