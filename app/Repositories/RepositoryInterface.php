<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function getItems();

    public function setItems($items);

    public function setError(bool $error);

    public function hasError(): bool;

    public function setErrorType(int $errorType);

    public function getErrorType();

    public function setApiErrorCode(string $apiErrorCode);

    public function getApiErrorCode();

    public function setHttpStatusCode(string $httpStatusCode);

    public function getHttpStatusCode();
}
