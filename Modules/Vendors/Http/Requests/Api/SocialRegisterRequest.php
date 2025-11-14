<?php

namespace Modules\Vendors\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Modules\Vendors\Http\Requests\WithHashedPassword;
use Modules\Support\Traits\ApiTrait;

class SocialRegisterRequest extends FormRequest
{
    use WithHashedPassword, ApiTrait;

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
            'name'             => ['required', 'string', 'max:255'],
            'device_token'     => ['required'],
            'phone'            => ['required'],
            'preferred_locale' => 'required|in:ar,en',
            'social_type'      => ['required', 'in:facebook,google,apple'],
            'email'            => ['required', 'email'],
            'social_id'        => ['required_with:social_type'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return array_merge(
            trans('vendors::vendors.attributes')
        );
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
