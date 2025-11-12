<?php

namespace Modules\Accounts\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Modules\Support\Traits\ApiTrait;

class RateApiRequest extends FormRequest
{
    use ApiTrait;

    /**
     * Determine if the supervisor is authorized to make this request.
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
            'vendor_id'  => ['nullable', 'exists:vendors,id'],
            'product_id' => ['nullable', 'exists:products,id'],
            'value'      => ['required', 'numeric', 'min:0', 'max:5'],
            'comment'    => ['sometimes', 'string'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('accounts::rate.attributes');
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

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->input('vendor_id') && !$this->input('product_id')) {
                $validator->errors()->add('vendor_id', 'Either vendor or product is required.');
            }
        });
    }

}
