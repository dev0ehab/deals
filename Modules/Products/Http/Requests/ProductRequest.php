<?php

namespace Modules\Products\Http\Requests;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        if ($this->isMethod('POST')) {
            return $this->createRules();
        } else {
            return $this->updateRules();
        }
    }

    /**
     * Get the create validation rules that apply to the request.
     *
     * @return array
     */
    public function createRules()
    {
        return RuleFactory::make([
            '%name%'        => ['required', 'string', 'max:255'],
            '%description%' => ['required', 'string'],
            "section_id"    => ['required', 'exists:sections,id'],
            "price"         => ['required', 'numeric', 'min:0.01'],
            "old_price"     => ['nullable', 'numeric', 'min:0.01'],
            'stock'         => ['required', 'integer', 'min:0'],
            'cover'         => ['required', 'mimes:jpeg,jpg,png', 'max:1000'],
            'images'        => ['required', 'array'],
            'images.*'      => ['required', 'mimes:jpeg,jpg,png', 'max:1000'],
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
            '%name%'        => ['required', 'string', 'max:255'],
            '%description%' => ['required', 'string'],
            "section_id"    => ['required', 'exists:sections,id'],
            "price"         => ['required', 'numeric', 'min:0.01'],
            "old_price"     => ['nullable', 'numeric', 'min:0.01'],
            'stock'         => ['required', 'integer', 'min:0'],
            'cover'         => ['nullable', 'mimes:jpeg,jpg,png', 'max:1000'],
            'images'        => ['nullable', 'array'],
            'images.*'      => ['nullable', 'mimes:jpeg,jpg,png', 'max:1000'],
        ]);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return RuleFactory::make(trans('products::products.attributes'));
    }
}
