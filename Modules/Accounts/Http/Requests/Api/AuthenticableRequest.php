<?php

namespace Modules\Accounts\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Modules\Accounts\Http\Requests\WithHashedPassword;
use Modules\Support\Traits\ApiTrait;

class AuthenticableRequest extends FormRequest
{
    use WithHashedPassword, ApiTrait;

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
            'username_type' => ['required', 'in:phone,email'],
            'username' => [
                'exclude_without:username_type',
                'required',
                "unique:users,$this->username_type",
                $this->username_type == 'email' ? 'email' : "numeric",
            ],
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
            trans('accounts::user.attributes'),
            [
                "username" => trans("accounts::user.attributes.$this->username_type"),
            ]
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
