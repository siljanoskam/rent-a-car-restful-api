<?php

namespace App\Traits;

use App\Api\ErrorCode;
use App\Response\Partials\ErrorWarning;
use App\Response\Std400Response;
use App\Response\Std500Response;
use App\Response\StdEmptyResponseInterface;
use Illuminate\Http\JsonResponse;

trait ApiUtils
{
    /**
     * Returns a JSON response with a status code based on the provided response object
     *
     * @param StdEmptyResponseInterface $response An object that implements
     * the StdEmptyResponseInterface
     *
     * @return JsonResponse
     */
    public static function response(StdEmptyResponseInterface $response): JsonResponse
    {
        return response()->json($response, $response->getStatusCode());
    }

    /**
     * A helper method that returns error responses for requests that have been
     * validated but failed at another step
     *
     * @param int $type The type of error response (400 or 500).
     * @param string $apiErrorCode The api error code to return to consumer.
     * @param string $api The api name to set on error.
     * @param int|null $statusCode The status code to send.
     *
     * @return JsonResponse
     */
    public static function errorResponse(string $apiErrorCode, int $type = 500, int $statusCode = null, string $api = 'RC'): JsonResponse
    {
        $response = $type === 400 ? new Std400Response() : new Std500Response();
        $response->setStatusCode($statusCode);

        $errorCode = new ErrorCode($api);

        $error = new ErrorWarning($errorCode->get($apiErrorCode));
        $error->setMessagesTranslation($apiErrorCode, 'apiErrors');

        $response->addError($error);

        return static::response($response);
    }
}
