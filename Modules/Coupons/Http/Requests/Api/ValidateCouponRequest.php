<?php

namespace Modules\Coupons\Http\Requests\Api;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Modules\Support\Traits\ApiTrait;

class ValidateCouponRequest extends FormRequest
{
    use ApiTrait;

    /**
     * Determine if the supervisor is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'coupon_code' => 'required|exists:coupons,code',
        ];
    }

    /**
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = $this->sendErrorData($validator->errors()->toArray(), $validator->errors()->first());

        throw new ValidationException($validator, $response);
    }

        /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return RuleFactory::make(trans('coupons::coupons.attributes'));
    }
}
