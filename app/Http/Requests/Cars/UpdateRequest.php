<?php

namespace App\Http\Requests\Cars;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Route;

class UpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => [
                'required',
                'integer',
                parent::ruleExistsValidationQuery('cars', 'id'),
            ],
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

    protected function validationData()
    {
        return parent::addIdPathParamToValidationData();
    }
}
