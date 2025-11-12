<?php

namespace Modules\Orders\Http\Requests;

use App\Enums\OrderStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Validation\Rules\Enum;

class ChangeStatusRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return RuleFactory::make(
            [
                "status"        => ["required", new Enum(OrderStatusEnum::class)],
                "cancel_reason" => "nullable|string",
            ]
        );
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return RuleFactory::make(trans('orders::orders.attributes'));
    }
}
