<?php

namespace App\Enums;

use ReflectionClass;
use ReflectionException;

abstract class StdEnum implements StdEnumInterface
{
    /**
     * Returns the list of all constants in an enumerator
     *
     * @return array
     */
    public static function all(): array
    {
        try {
            $reflect = new ReflectionClass(static::class);
            return $reflect->getConstants();
        } catch (ReflectionException $exception) {
            return [];
        }
    }
}
