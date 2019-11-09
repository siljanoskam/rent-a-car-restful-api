<?php

namespace App\Api;

class ErrorCode
{
    /**
     * The application name. Obtained from config (config/app.php)
     * @var string
     */
    protected $appName;

    /**
     * The current api being accessed. Set on instantiation.
     * @var string
     */
    protected $api;

    /**
     * The error code format as defined on config/api.php
     * @var mixed
     */
    protected $errorCodeFormat;

    /**
     * ApiError constructor.
     *
     * @param $api
     */
    public function __construct(string $api)
    {
        $this->api = $api;
        $this->errorCodeFormat = config('app.errorCodePrefixFormat');
        $this->appName = config('app.name');
    }

    public function get(string $code): string
    {
        return sprintf($this->errorCodeFormat, $this->api, $code);
    }
}
