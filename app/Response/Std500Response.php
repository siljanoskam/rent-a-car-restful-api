<?php

namespace App\Response;

use App\Response\Partials\ErrorWarning as ErrorWarningPartial;
use Illuminate\Http\Response as HttpStatusCode;

/**
 * A response that will show the consumer the errors for a 500 response.
 */
class Std500Response extends StdResponse
{
    /**
     * The status code for a standard 500 response.
     * @var int
     */
    protected $statusCode = HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR;

    /**
     * The list of errors on the response
     * @var ErrorWarningPartial[]
     */
    public $errors;

    /**
     * Add a single error to the response
     * @param ErrorWarningPartial $warning
     */
    public function addError(ErrorWarningPartial $warning)
    {
        $this->errors[] = $warning;
    }

    /**
     * Add a list of errors to the response
     * @param ErrorWarningPartial[] $warnings
     */
    public function setErrors(array $warnings)
    {
        $this->errors = $warnings;
    }
}
