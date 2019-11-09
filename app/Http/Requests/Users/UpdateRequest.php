<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\BaseRequest;

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
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'birthDate' => 'string',
            'phoneNumber' => 'string'
        ];
    }
}
