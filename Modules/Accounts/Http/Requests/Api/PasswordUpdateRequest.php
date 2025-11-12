<?php

namespace Modules\Accounts\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Modules\Accounts\Http\Requests\WithHashedPassword;
use Modules\Accounts\Rules\NewPasswordRule;
use Modules\Accounts\Rules\PasswordRule;
use Modules\Support\Traits\ApiTrait;

class PasswordUpdateRequest extends FormRequest
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
            'old_password' => ['required_with:password', new PasswordRule(auth()->user()->password ?? 'password')],
            'password' => ['sometimes', 'min:8', 'confirmed' , new NewPasswordRule($this->old_password)],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('accounts::user.attributes');
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
