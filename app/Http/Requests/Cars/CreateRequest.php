<?php

namespace App\Http\Requests\Cars;

use App\Http\Requests\BaseRequest;

class CreateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'brand' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|numeric',
            'fuelType' => 'required|string',
            'price' => 'required|numeric',
            'available' => 'required|boolean',
            'locationId' => [
                'required',
                'integer',
                parent::ruleExistsValidationQuery('locations', 'id')
            ]
        ];
    }
}
