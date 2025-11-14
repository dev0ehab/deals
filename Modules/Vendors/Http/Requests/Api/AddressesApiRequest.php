<?php

namespace Modules\Vendors\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Modules\Support\Traits\ApiTrait;

class AddressesApiRequest extends FormRequest
{
    use ApiTrait;

    /**
     * Determine if the supervisor is authorized to make this request.
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
            'building_number'    => ['nullable', 'string', 'max:3'],
            'appartement_number' => ['nullable', 'string', 'max:3'],
            'floor_number'       => ['nullable', 'string' , 'max:3'],
            'street_name'        => ['required', 'string'],
            'area_id'            => ['required', 'exists:areas,id'],
            'landmark'           => ['nullable', 'string'],
            'area'               => ['nullable', 'string'],
            'lat'                => ['required', 'string'],
            'long'               => ['required', 'string'],
            'type'               => ['nullable', 'string'],
        ];
    }



    public function prepareForValidation()
    {

        $area = getAddressArea($this->lat, $this->long);

        if (!$area) {
            $this->errors()->add('area', __('addresses::addresses.outside_area'));
        }

        $this->merge([
            'area_id' => $area?->id,
        ]);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('addresses::addresses.attributes');
    }

    /**
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = $this->sendErrorData($validator->errors()->toArray(), $validator->errors()->first());

        throw new ValidationException($validator, $response);
    }
}
