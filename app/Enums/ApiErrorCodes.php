<?php

namespace App\Enums;

abstract class ApiErrorCodes extends StdEnum
{
    const STD400 = 400;
    const STD404 = 404;
    const STD422 = 422;
    const STD500 = 500;
}
