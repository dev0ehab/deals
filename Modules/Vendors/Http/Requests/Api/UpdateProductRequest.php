<?php

namespace Modules\Vendors\Http\Requests\Api;

use App\Enums\ProductDiscountTypeEnum;
use App\Enums\ProductTypeEnum;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Modules\Products\Entities\Product;
use Modules\Support\Traits\ApiTrait;

class UpdateProductRequest extends FormRequest
{
    use ApiTrait;

    /**
     * Determine if the vendor is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $vendor = $this->user();
        $vendorSectionIds = $vendor->sections()->pluck('sections.id')->toArray();

        return RuleFactory::make([
            '%name%'        => ['sometimes', 'required', 'string', 'max:255'],
            '%description%' => ['sometimes', 'required', 'string'],
            "section_id"    => ['sometimes', 'required', 'exists:sections,id', function ($attribute, $value, $fail) use ($vendorSectionIds) {
                if (!in_array($value, $vendorSectionIds)) {
                    $fail(trans('products::products.messages.section_not_belongs_to_vendor'));
                }
            }],
            "price"         => ['sometimes', 'required', 'numeric', 'min:0.01'],
            "old_price"     => ['nullable', 'numeric', 'min:0.01'],
            'stock'         => ['sometimes', 'required', 'integer', 'min:0'],
            'product_type'  => ['sometimes', 'required', Rule::enum(ProductTypeEnum::class)],
            'discount_type' => ['sometimes', 'required', Rule::enum(ProductDiscountTypeEnum::class)],
            'offer_end_date' => [
                'nullable',
                'date',
                'after:today',
                function ($attribute, $value, $fail) {
                    $discountType = $this->discount_type ?? Product::find($this->route('product'))?->discount_type;
                    if ($discountType === ProductDiscountTypeEnum::OFFER->value && empty($value)) {
                        $fail(trans('products::products.messages.offer_end_date_required'));
                    }
                },
            ],
            'cover'         => ['sometimes', 'nullable', 'mimes:jpeg,jpg,png', 'max:10000'],
            'images'        => ['sometimes', 'nullable', 'array'],
            'images.*'      => ['required_with:images', 'mimes:jpeg,jpg,png', 'max:10000'],
        ]);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return RuleFactory::make(trans('products::products.attributes'));
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
}

