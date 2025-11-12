<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterValidation extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'firstName' => 'required|max:25',
            'lastName' => 'required|max:25',
            'email' => 'required|max:125|email|unique:users',
            'phone' => 'required|regex:/(05)[0-9]{8}/|max:10|unique:users',
            'date' => 'required|date_format:m/d/Y|before:today',
            'type' => 'required',
            // 'communication' => 'required',
            'password' => 'required|min:6|max:25|confirmed',
            'password_confirmation' => 'required_with:password|same:password|min:6|max:25'
            // 'photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'firstName.required' => __('First name is required'),
            'lastName.required' => __('Last name is required'),
            'email.required' => __('email is required'),
            'phone.required' => __('phone required'),
            'date.required' => __('Data of birth is required'),
            'date.date_format' => __('Enter the date of birth correctly'),
            'type.required' => __('User type is required to be selected'),
            // 'communication.required' => ' طريقة التواصل مطلوب اختيارة ',
            'password.required' => __('password is required'),
            'password.confirmed' => __('Password does not match'),
            'password.min' => __('Password must not be less than six digits'),
            'password.max' => __('Password must not be greater than twenty-five numbers'),
            'firstName.max' => __('The first name field cannot be longer than 25 characters'),
            'lastName.max' => __('The last name field cannot be longer than 25 characters'),
            'email.max' => __('The email field cannot be longer than 25 characters'),
        ];        
    }
}
