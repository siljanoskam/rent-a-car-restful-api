<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'birthDate' => 'string',
            'phoneNumber' => 'string',
            'role' => [
                'required',
                'integer',
                parent::ruleExistsValidationQuery('roles', 'id')
            ]
        ];
    }
}
