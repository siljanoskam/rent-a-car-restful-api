<?php

namespace App\Http\Requests\Cars;

use App\Http\Requests\BaseRequest;

class ListRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'available' => [
                'sometimes',
                'string'
            ],
            'rented' => [
                'sometimes',
                'string'
            ],
            'location' => [
                'sometimes',
                'string'
            ],
            'minPrice' => [
                'sometimes',
                'numeric'
            ],
            'maxPrice' => [
                'sometimes',
                'numeric'
            ],
            'brand' => [
                'sometimes',
                'string'
            ],
            'model' => [
                'sometimes',
                'string'
            ],
            'year' => [
                'sometimes',
                'integer'
            ]
        ];
    }
}
