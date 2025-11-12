<?php

namespace Modules\Products\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFeatureRequest extends FormRequest
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
        $featureType = $this->input('feature_type');
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        $rules = [
            'feature_id'   => ['nullable', 'exists:features,id'],
            'feature_type' => ['required', 'in:text,image,data'],
            'is_active'    => ['nullable'],
            'text_ar'      => ['nullable', 'string', 'max:5000'],
            'text_en'      => ['nullable', 'string', 'max:5000'],
            'image'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,jpeg,svg', 'max:2048'],
        ];

        // Conditional rules based on feature type
        switch ($featureType) {
            case 'text':
                break;

            case 'image':
                break;

            case 'data':
                $rules['feature_id']        = ['required', 'exists:features,id'];
                $rules['feature_options']   = ['required', 'array', 'min:1'];
                $rules['feature_options.*'] = ['required', 'exists:feature_options,id'];
                break;
        }

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'feature_id'        => trans('products::products.features.select_feature', [], app()->getLocale()),
            'feature_type'      => trans('products::products.features.feature_type', [], app()->getLocale()),
            'text_ar'           => trans('products::products.features.text_ar', [], app()->getLocale()),
            'text_en'           => trans('products::products.features.text_en', [], app()->getLocale()),
            'text_value_ar'     => trans('products::products.features.text_value_ar', [], app()->getLocale()),
            'text_value_en'     => trans('products::products.features.text_value_en', [], app()->getLocale()),
            'image'             => trans('products::products.features.image', [], app()->getLocale()),
            'feature_options'   => trans('products::products.features.feature_options', [], app()->getLocale()),
            'feature_options.*' => trans('products::products.features.select_options', [], app()->getLocale()),
            'is_active'         => trans('products::products.attributes.is_active', [], app()->getLocale()),
        ];
    }
}

