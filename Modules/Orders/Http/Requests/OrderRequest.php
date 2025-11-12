<?php

namespace Modules\Orders\Http\Requests;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Support\Traits\ApiTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderRequest extends FormRequest
{
    use ApiTrait;
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'payment_id'                               => ['required', 'numeric'],
            "coupon_code"                              => ['nullable', 'exists:coupons,code'],
            'delivery_type'                            => ['required', 'in:delivery,pickup'],
            'print'                                    => ['sometimes', 'array'],
            'print.*.media_id'                         => ['required', 'exists:media,id'],
            'print.*.copies'                           => ['required', 'numeric', 'min:1'],
            'print.*.attributes'                       => ['required', 'array'],
            'print.*.attributes.*.attribute_id'        => ['required', 'exists:attributes,id'],
            'print.*.attributes.*.attribute_option_id' => ['nullable', 'exists:attribute_options,id'],
            'address_id'                               => ['nullable', 'exists:addresses,id,user_id,' . auth()->id()],
            "products"                                 => ['sometimes', 'array'],
            "products.*.id"                            => ['required', 'exists:products,id'],
            "products.*.quantity"                      => ['required', 'numeric', 'min:1'],
            "products.*.features"                      => ['sometimes', 'array'],
            "products.*.features.*.product_feature_id" => ['required', 'exists:product_features,id'],
            "products.*.features.*.feature_option_id"  => ['nullable', 'exists:feature_options,id'],
            "products.*.features.*.option"             => ['nullable', 'string'],
            "products.*.features.*.image"              => ['nullable', 'image', 'mimes:jpeg,png,jpg,jpeg,svg', 'max:2048'],
        ];
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
