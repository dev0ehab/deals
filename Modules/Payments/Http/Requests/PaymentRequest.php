<?php

namespace Modules\Payments\Http\Requests;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('POST')) {
            return $this->createRules();
        }

        return $this->updateRules();
    }

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
     * Get the create validation rules that apply to the request.
     *
     * @return array
     */
    public function createRules()
    {
        // $this->errorBag = 'payment';

        return RuleFactory::make([
            'name:ar' => ['required', 'string', 'max:255'],
            'name:en' => ['required', 'string', 'max:255'],
            'image' => ['required', 'mimes:jpeg,jpg,png', 'max:1000'],
        ]);
    }

    /**
     * Get the update validation rules that apply to the request.
     *
     * @return array
     */
    public function updateRules()
    {
        return RuleFactory::make([
            'name:ar' => ['required', 'string', 'max:255'],
            'name:en' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'mimes:jpeg,jpg,png', 'max:1000'],
        ]);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return RuleFactory::make(trans('payments::payments.attributes'));
    }
}
