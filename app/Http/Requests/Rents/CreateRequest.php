<?php

namespace App\Http\Requests\Rents;

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
            'startDate' => 'required|string',
            'endDate' => 'required|string',
            'startingLocation' => [
                'required',
                'integer',
                parent::ruleExistsValidationQuery('locations', 'id')
            ],
            'endingLocation' => [
                'required',
                'integer',
                parent::ruleExistsValidationQuery('locations', 'id')
            ],
            'carId' => [
                'required',
                'integer',
                parent::ruleExistsValidationQuery('cars', 'id')
            ]
        ];
    }
}
