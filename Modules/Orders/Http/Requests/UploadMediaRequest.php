<?php

namespace Modules\Orders\Http\Requests;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Support\Traits\ApiTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class UploadMediaRequest extends FormRequest
{
    use ApiTrait;

    /**
     * Get the create validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'files'      => ['required', 'array'],
            'files.*'    => ['required', 'file', 'mimes:pdf,pptx', 'max:10000'],
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

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return RuleFactory::make(trans('orders::orders.attributes'));
    }

    public function failedValidation(  $validator)
    {
        throw new HttpResponseException($this->sendErrorData($validator->errors(), $validator->errors()->first()));
    }

}
