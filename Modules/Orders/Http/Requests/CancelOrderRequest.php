<?php

namespace Modules\Orders\Http\Requests;

use App\Enums\OrderStatusEnum;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Support\Traits\ApiTrait;

class CancelOrderRequest extends FormRequest
{
    use ApiTrait;

    /**
     * Get the create validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status'        => ['required'],
            'cancel_reason' => ['required', 'string', 'max:255'],
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->order->status != OrderStatusEnum::PENDING->value) {
                // $validator->errors()->add('status', __('orders::orders.messages.you_can_not_cancel_this_order_cause_it_s_not_pending'));
            }
        });
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status'        => OrderStatusEnum::CANCELLED,
            "cancel_reason" => $this->cancel_reason ?? "--"
        ]);



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
