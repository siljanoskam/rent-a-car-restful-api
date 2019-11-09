<?php

namespace App\Response\Partials;

/**
 * Defines how a simple id/name object is built. Forces a specific structure on
 * output responses. Helps creating consistent responses.
 */
class IdName
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id ?? 0;
        $this->name = $name ?? '';
    }
}
