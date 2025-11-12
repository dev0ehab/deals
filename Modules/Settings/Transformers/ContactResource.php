<?php

namespace Modules\Settings\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Laraeast\LaravelSettings\Facades\Settings;

class ContactResource extends JsonResource
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
            'phones' => Settings::get('phones'),
            'email' => Settings::get('email'),
            'whats_app' => Settings::get('whats_app'),
            'facebook' => Settings::get('facebook'),
            'instagram' => Settings::get('instagram'),
            'snapchat' => Settings::get('snapchat'),
            'telegram' => Settings::get('telegram'),
            'x' => Settings::get('x'),
        ];
    }
}
