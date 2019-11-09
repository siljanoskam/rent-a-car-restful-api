<?php

namespace App\Http\Requests\Rents;

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
            'active' => 'sometimes|boolean',
            'finished' => 'sometimes|boolean'
        ];
    }
}
