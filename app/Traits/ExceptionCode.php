<?php

namespace App\Traits;

use App\Enums\ExceptionCode as ExceptionCodeEnum;

trait ExceptionCode
{
    /**
     * Returns the list of Api errors available
     *
     * @return array
     */
    public static function allMapped()
    {
        $exceptionCodes = ExceptionCodeEnum::all();

        return [
            $exceptionCodes['CE'] => 'CE',
            $exceptionCodes['CE_FE_COMM'] => 'CE_FE_COMM',
            $exceptionCodes['CE_FE_COMM_STORE'] => 'CE_FE_COMM_STORE',
            $exceptionCodes['CE_VALIDATION'] => 'CE_VALIDATION',
            $exceptionCodes['CE_UNAUTHORIZED'] => 'CE_UNAUTHORIZED',

            $exceptionCodes['W'] => 'W',
            $exceptionCodes['W_MISSING_DATA'] => 'W_MISSING_DATA',
        ];
    }

    /**
     * Returns an error code for outputting to API consumers
     *
     * @param int $code
     *
     * @return string
     */
    public static function errorCodeString(int $code): string
    {
        $errorList = static::allMapped();
        return $errorList[$code] ?? '';
    }
}
