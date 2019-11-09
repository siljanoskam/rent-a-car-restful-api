<?php

namespace App\Enums;

abstract class ApiError extends StdEnum
{
    const NOT_FOUND = 'NOT_FOUND';
    const COULD_NOT_DELETE = 'COULD_NOT_DELETE';
    const SEARCH_FAILURE = 'SEARCH_FAILURE';
    const CREATION_FAILURE = 'CREATION_FAILURE';
    const COULD_NOT_UPDATE = 'COULD_NOT_UPDATE';
    const INVALID_REQUEST_DATA = 'INVALID_REQUEST_DATA';
    const LIST_FAILURE = 'LIST_FAILURE';
    const UNAUTHORIZED = 'UNAUTHORIZED';
}
