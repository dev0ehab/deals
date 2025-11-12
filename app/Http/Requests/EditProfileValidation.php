<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProfileValidation extends FormRequest
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
            'name' => 'alpha|max:25',
            'last_name' => 'alpha|max:25',
            'email' => 'email|max:125',
            'phone' => 'regex:/(05)[0-9]{8}/|max:10',
            'dob' => 'sometimes|before:today',
        ];
    }

    public function messages(): array
    {
        return [
            'name.alpha' => __('First name field must contain letters'),
            'last_name.alpha' => __('Last name field must contain letters'),
            'email.email' => __('Email not correct'),
            'phone.regex' => __('Phone number must start with 05 and contain ten numbers'),
            // 'dob.' => 'تأكد من ادخال تاريخ الميلاد بشكل صحيح',
        ];        
    }
}
