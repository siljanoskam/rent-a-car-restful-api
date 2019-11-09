<?php

namespace App\Http\Requests;

use App\Response\Std400Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

class BaseRequest extends FormRequest
{
    /**
     * Set a validation error response here
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $httpStatusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        $response = new Std400Response();
        $response->setStatusCode($httpStatusCode);
        $response->setErrors([$validator->errors()]);

        throw new HttpResponseException(
            response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

    /**
     * Helper method to build a Rule::exists validation rule.
     *
     * @param string $table The table where column exists.
     * @param string $column The column corresponding to the field value to check.
     *
     * @return Exists
     */
    protected static function ruleExistsValidationQuery(string $table, string $column): Exists
    {
        return Rule::exists($table, $column);
    }

    /**
     * Adds the Id path parameter to the validation data array
     *
     * @return array
     */
    protected function addIdPathParamToValidationData(): array
    {
        return array_merge($this->request->all(), [
            'id' => Route::input('id')
        ]);
    }
}
