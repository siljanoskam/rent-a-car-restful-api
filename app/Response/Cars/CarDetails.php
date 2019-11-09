<?php

namespace App\Response\Cars;

/**
 * Defines user details response object.
 * Forces a specific structure on output responses.
 * Helps creating consistent responses.
 */
class CarDetails
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $brand;

    /**
     * @var string
     */
    public $model;

    /**
     * @var int
     */
    public $year;

    /**
     * @var string
     */
    public $fuelType;

    /**
     * @var double
     */
    public $price;

    /**
     * @var boolean
     */
    public $available;

    /**
     * @var string
     */
    public $location;

    public function __construct(
        int $id,
        string $brand,
        string $model,
        int $year,
        string $fuelType,
        float $price,
        bool $available,
        string $location
    ) {
        $this->id = $id;
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
        $this->fuelType = $fuelType;
        $this->price = $price;
        $this->available = $available;
        $this->location = $location;
    }
}
