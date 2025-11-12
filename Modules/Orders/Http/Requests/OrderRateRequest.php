<?php

namespace Modules\Orders\Http\Requests;

use App\Enums\OrderStatusEnum;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Support\Traits\ApiTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderRateRequest extends FormRequest
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
            'print_rate'               => ['required_without:order_products', 'numeric', 'min:0' , 'max:5'],
            "order_products"           => ['required_without:print_rate', 'array'],
            "order_products.*.id"      => ['required', 'exists:order_products,id'],
            "order_products.*.rate"    => ['required', 'numeric', 'min:0', 'max:5'],
            "order_products.*.comment" => ['nullable', 'string' , 'max:255'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->order->status != OrderStatusEnum::DELIVERED ) {
                $validator->errors()->add('order_products', __('orders::validation.you_can_not_rate_the_order_cause_it_s_not_delivered'));
            }
        });
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

    public function failedValidation(  $validator)
    {
        throw new HttpResponseException($this->sendErrorData($validator->errors(), $validator->errors()->first()));
    }

}
