<?php

namespace Modules\Vendors\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Modules\Support\Traits\ApiTrait;

class UpdateStoreRequest extends FormRequest
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
        return [
            'store_name'           => ['sometimes', 'string', 'max:255'],
            'store_description_ar' => ['sometimes', 'nullable', 'string'],
            'store_description_en' => ['sometimes', 'nullable', 'string'],
            'sections'             => ['sometimes', 'array'],
            'sections.*'           => ['exists:sections,id'],
            'logo'                 => ['sometimes', 'mimes:jpeg,jpg,png', 'max:10000'],
            'banners'              => ['sometimes', 'array'],
            'banners.*'            => ['sometimes', 'mimes:jpeg,jpg,png', 'max:10000'],
        ];
    }


    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            if (is_null($this->user()->is_accepted) && $this->user()->store_name) {
                $validator->errors()->add('store_name', __('vendors::vendors.messages.store_is_under_review'));
            }
        });
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('vendors::vendors.attributes');
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

