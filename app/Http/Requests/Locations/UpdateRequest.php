<?php

namespace App\Http\Requests\Locations;

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
                parent::ruleExistsValidationQuery('locations', 'id'),
            ],
            'email' => 'required|email|unique:locations,email,' . Route::input('id'),
            'name' => 'required|string',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'phoneNumber' => 'string'
        ];
    }

    protected function validationData()
    {
        return parent::addIdPathParamToValidationData();
    }
}
