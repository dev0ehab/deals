<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordValidation extends FormRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            
            'password' => 'required|min:6|max:25|confirmed',
            'current_password' => 'required|min:6|max:25',
            
            // 'validate_password' => 'required_with:new_password|same:new_password|min:6|max:25'
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => __('password is required'),
            'password.required' => __('password is required'),
            'password.confirmed' => __('Password does not match'),
            'password.min' => __('Password must not be less than six digits'),
            'password.max' => __('Password must not be greater than twenty-five numbers'),
            // 'validate_password:same'=> 'كلمة المرور غير مطابقه',
            // 'validate_password.required_with' => 'حقل كلمة تلأكيد كلمة مطلوب إدخالة',
        ];
    }
}
