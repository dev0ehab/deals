<?php

namespace Modules\Services\Http\Requests;

use App\Enums\ServicesEnum;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            $data = $this->createRules();
        } else {
            $data = $this->updateRules();
        }

        return array_merge($data, get_service_validation_rules($this));
    }

    /**
     * Get the create validation rules that apply to the request.
     *
     * @return array
     */
    public function createRules()
    {
        return RuleFactory::make([
            '%name%' => ['required', 'string', 'max:255'],
            '%title%' => ['required', 'string', 'max:255'],
            '%description%' => ['required', 'string'],
            'cover' => ['required', 'mimes:jpeg,jpg,png', 'max:10000'],
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
            '%name%' => ['required', 'string', 'max:255'],
            '%title%' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric' , "min:.01" ],
            '%description%' => ['required', 'string'],
            'cover' => ['nullable', 'mimes:jpeg,jpg,png', 'max:10000'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'mimes:jpeg,jpg,png', 'max:10000'],
        ]);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return RuleFactory::make(trans('services::services.attributes'));
    }
}
