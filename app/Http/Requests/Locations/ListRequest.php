<?php

namespace App\Http\Requests\Locations;

use App\Http\Requests\BaseRequest;
use Illuminate\Http\Request;

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
            'name' => [
                'sometimes',
                'string'
            ],
            'address' => [
                'sometimes',
                'string'
            ]
        ];
    }
}
