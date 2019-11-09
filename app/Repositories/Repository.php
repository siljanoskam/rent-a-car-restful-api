<?php

namespace App\Repositories;

use App\Response\Std200ListResponse;
use App\Response\Std200Response;
use App\Response\StdEmptyResponse;
use Illuminate\Http\Response as HttpStatusCode;

class Repository implements RepositoryInterface
{
    protected $items;
    protected $error;
    protected $errorType;
    protected $apiErrorCode;
    protected $httpStatusCode;
    protected $std200Response;
    protected $std200ListResponse;
    protected $stdEmptyResponse;

    public function __construct()
    {
        $this->items = new StdEmptyResponse();
        $this->error = false;
        $this->errorType = 0;
        $this->apiErrorCode = '';
        $this->httpStatusCode = HttpStatusCode::HTTP_OK;

        $this->std200Response = new Std200Response();
        $this->std200ListResponse = new Std200ListResponse();
        $this->stdEmptyResponse = new StdEmptyResponse(HttpStatusCode::HTTP_NO_CONTENT);
    }

    public function getItems()
    {
        return $this->items;
    }

    public function setItems($items): Repository
    {
        $this->items = $items;

        return $this;
    }

    public function setError(Bool $error): Repository
    {
        $this->error = $error;

        return $this;
    }

    public function hasError(): Bool
    {
        return $this->error;
    }

    public function setErrorType(int $errorType): Repository
    {
        $this->errorType = $errorType;

        return $this;
    }

    public function getErrorType(): string
    {
        return $this->errorType;
    }

    public function setApiErrorCode(string $apiErrorCode): Repository
    {
        $this->apiErrorCode = $apiErrorCode;

        return $this;
    }

    public function getApiErrorCode(): string
    {
        return $this->apiErrorCode;
    }

    public function setHttpStatusCode(string $httpStatusCode): Repository
    {
        $this->httpStatusCode = $httpStatusCode;

        return $this;
    }

    public function getHttpStatusCode(): string
    {
        return $this->httpStatusCode;
    }
}
