<?php

namespace App\Http\Requests\Cars;

use App\Http\Requests\BaseRequest;

class DeleteRequest extends BaseRequest
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
                parent::ruleExistsValidationQuery('cars', 'id')
            ]
        ];
    }

    protected function validationData()
    {
        return parent::addIdPathParamToValidationData();
    }
}
