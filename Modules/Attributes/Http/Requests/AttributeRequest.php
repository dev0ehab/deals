<?php

namespace Modules\Attributes\Http\Requests;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class AttributeRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return
            [
                'title:ar'                     => ['required', 'string'],
                'title:en'                     => ['required', 'string'],
                'description:ar'               => ['nullable', 'string'],
                'description:en'               => ['nullable', 'string'],
                'type'                         => ['required', 'string', 'in:select,text'],
                'pricing_type'                 => ['required', 'string', 'in:paper_price,total_price,no_price'],
                'price'                        => ['nullable', 'numeric', 'min:0'],
                'is_active'                    => ['required', 'boolean'],
                'options'                      => ['required_if:type,select', 'array'],
                'options.*.id'                 => ['nullable', 'string'],
                'options.*.name:ar'            => ['required', 'string'],
                'options.*.name:en'            => ['required', 'string'],
                'options.*.image'              => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:5000'],
                'options.*.icon'               => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:5000'],
                'options.*.is_default'         => ['nullable', 'in:0,1'],
                'options.*.paper_count_factor' => ['nullable', 'numeric', 'min:.1'],
                'options.*.price'              => ['nullable', 'numeric', 'min:.1'],
            ];
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


    public function prepareForValidation()
    {
        $this->merge([
            'options' => $this->type == 'text' ? [] : $this->options,
        ]);

        if (isset($this->options)) {
            $data = $this->options;
            foreach ($data as $index => $option) {
                $data[$index]['is_default'] = isset($option['is_default'])  ? $option['is_default'][0] : 0  ;
                $data[$index]['paper_count_factor'] = isset($option['paper_count_factor'])  ? $option['paper_count_factor'][0] : 1;
                $data[$index]['price'] = isset($option['price'])  ? $option['price'][0] : null;
            }
            $this->merge([
                'options' => $data
            ]);
        }



    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return RuleFactory::make(trans('attributes::attributes.attributes'));
    }
}
