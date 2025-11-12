<?php

namespace Modules\Coupons\Http\Requests;

use App\Enums\CouponDiscountTypeEnum;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('POST')) {
            return $this->createRules();
        }

        return $this->updateRules();
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // If discount_type is delivery, set default values for percentage_discount and max_discount
        if ($this->discount_type === 'delivery') {
            $this->merge([
                'percentage_discount' => 100,
                'max_discount' => 10000,
            ]);
        }

        if ($this->coupon_type === 'fixed') {
            $this->merge([
                'percentage_discount' => 100,
            ]);
        }

        // Set default coupon_type if not provided and discount_type is total
        if (!$this->has('coupon_type') && $this->discount_type === 'total') {
            // For existing coupons without coupon_type, determine based on percentage_discount
            if (isset($this->coupon) && $this->coupon->discount_type === 'total') {
                $existingCouponType = $this->coupon->coupon_type ?? ($this->coupon->percentage_discount > 0 ? 'percent' : 'fixed');
                $this->merge(['coupon_type' => $existingCouponType]);
            } else {
                $this->merge(['coupon_type' => 'percent']);
            }
        }

        // Don't clear percentage_discount, let validation handle it
        // If coupon_type is fixed and percentage_discount is provided, validation will handle it
    }

    /**
     * Get the create validation rules that apply to the request.
     *
     * @return array
     */
    public function createRules()
    {
        return RuleFactory::make([
            'code' => ['required', 'string', 'max:255', "unique:coupons,code"],
            'description:ar' => ['required', 'string', 'max:1000'],
            'description:en' => ['required', 'string', 'max:1000'],
            'discount_type' => ['required', 'in:' . implode(',', CouponDiscountTypeEnum::values())],
            'coupon_type' => ['required_if:discount_type,total', 'in:fixed,percent'],

            'percentage_discount' => ['required_if:coupon_type,percent', 'min:1', 'max:100'],
            'max_discount' => ['required_if:discount_type,total'],

            'max_usage' => ['required', 'gt:max_usage_per_user'],
            'max_usage_per_user' => ['required'],
            'first_order_count' => ['nullable', 'integer', 'min:1'],

            'start_at' => ['required', 'date', 'after_or_equal:today'],
            'expire_at' => ['required', 'date', 'after:start_at'],

            'audience' => ['required', 'in:all,specific'],
            "users" => ['required_if:audience,specific', 'array'],
            "users.*" => ['nullable', 'exists:users,id'],
        ]);
    }

    /**
     * Get the update validation rules that apply to the request.
     *
     * @return array
     */
    public function updateRules()
    {
        return RuleFactory::make([
            'description:ar'      => ['required', 'string', 'max:1000'],
            'description:en'      => ['required', 'string', 'max:1000'],
            'discount_type'       => ['required', 'in:' . implode(',', CouponDiscountTypeEnum::values())],
            'coupon_type'         => ['required_if:discount_type,total', 'in:fixed,percent'],
            'percentage_discount' => ['required_if:coupon_type,percent', "gte:" . ($this->coupon->percentage_discount ?? 0), 'max:100'],
            'max_discount'        => ['required_if:discount_type,total', "gte:" . $this->coupon->max_discount],

            'max_usage'          => ['required', "gte:" . $this->coupon->max_usage],
            'max_usage_per_user' => ['required', "gte:" . $this->coupon->max_usage_per_user],
            'first_order_count'  => ['nullable', 'integer', 'min:1'],

            'expire_at' => ['required', 'date', 'after_or_equal:' . $this->coupon->end_at],

            'audience' => ['required', 'in:all,specific'],
            "users"    => ['required_if:audience,specific', 'array'],
            "users.*"  => ['nullable', 'exists:users,id'],
        ]);
    }


    public function messages()
    {
        return [
            'start_at.after_or_equal' => trans('coupons::coupons.messages.start_at_after_or_equal'),
        ];
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
