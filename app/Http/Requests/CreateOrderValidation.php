<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderValidation extends FormRequest
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
            'photos' => 'required|array',
            'orderName' => 'required',
            'orderDescription' => 'required',
            'startPrice' => 'required|lt:endPrice',
            'endPrice' => 'required|gt:startPrice',
            'Section' => 'required',
            'product' => 'required',
            'phone' => 'required|regex:/(05)[0-9]{8}/|max:10',
            'contact' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'photo.required' => __('photo required'),
            'orderName.required' => __('orderName required'),
            'orderDescription.required' =>  __('orderDescription required'),
            'startPrice.required' => __('startPrice required'),
            'endPrice.required' =>  __('endPrice required'),
            'startPrice.lt' => __('The initial price should be less than the final price'),
            'endPrice.gt' =>  __('The final price must be greater than the initial price'),
            'Section.required' =>  __('Country required'),
            'product.required' => __('City required'),
            'phone.regex' =>  __('Phone number must start with 05 and contain ten numbers'),
            'phone.required' => __('phone required'),
            'contact.required' =>  __('choose contact type')

        ];
    }
}
