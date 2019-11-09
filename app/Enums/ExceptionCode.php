<?php

namespace App\Enums;

/**
 * Class ErrorCode
 * Holds error codes for use with exceptions that expect integers
 * 9XXX Errors = critical errors
 * @package App\Enums
 */
class ExceptionCode extends StdEnum
{
    // CE = Critical Error. Errors with these codes should mean complete operation failure.
    const CE = 9000;

    // communication error
    const CE_FE_COMM = 9010;
    // communication error when using STORE
    const CE_FE_COMM_STORE = 9013;
    // a validation error occurred
    const CE_VALIDATION = 9020;
    const CE_UNAUTHORIZED = 9401;

    // W = warning. Errors with these codes should be logged but operation should continue.
    const W = 1000;
    const W_MISSING_DATA = 1015;
}
