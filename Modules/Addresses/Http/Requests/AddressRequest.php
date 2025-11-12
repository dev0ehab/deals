<?php

namespace Modules\Addresses\Http\Requests;

use App\Enums\AddressTypesEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Modules\Support\Traits\ApiTrait;
use Illuminate\Validation\Rules\Enum;


class AddressRequest extends FormRequest
{
    use ApiTrait;


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->isMethod('POST')) {
            return $this->createRules();
        }

        return $this->updateRules();
    }


    /**
     * Get the create validation rules that apply to the request.
     *
     * @return array
     */
    public function createRules()
    {
        return [
            'building_number'    => ['required', 'string', 'max:3'],
            'appartement_number' => ['required', 'string', 'max:3'],
            'floor_number'       => ['required', 'string', 'max:3'],
            'street_name'        => ['required', 'string'],
            'landmark'           => ['required', 'string'],
            'address'            => ['required', 'string'],
            'area'               => ['required', 'string'],
            'lat'                => ['required', 'string'],
            'long'               => ['required', 'string'],
            'type'               => ['required', new Enum(AddressTypesEnum::class)],
        ];
    }

    /**
     * Get the update validation rules that apply to the request.
     *
     * @return array
     */
    public function updateRules()
    {
        return [
            'building_number'    => ['sometimes', 'string', 'max:3'],
            'appartement_number' => ['sometimes', 'string', 'max:3'],
            'floor_number'       => ['sometimes', 'string', 'max:3'],
            'street_name'        => ['sometimes', 'string'],
            'landmark'           => ['sometimes', 'string'],
            'address'            => ['sometimes', 'string'],
            'area'               => ['sometimes', 'string'],
            'lat'                => ['sometimes', 'string'],
            'long'               => ['sometimes', 'string'],
            'type'               => ['sometimes', new Enum(AddressTypesEnum::class)],
        ];
    }



    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            deliveryPrice($this->lat , $this->long);
        });
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
