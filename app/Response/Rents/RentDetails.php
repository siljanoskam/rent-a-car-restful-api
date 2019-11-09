<?php

namespace App\Response\Rents;

use App\Response\Partials\IdName;

/**
 * Defines user details response object.
 * Forces a specific structure on output responses.
 * Helps creating consistent responses.
 */
class RentDetails
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $startDate;

    /**
     * @var string
     */
    public $endDate;

    /**
     * @var IdName
     */
    public $startingLocation;

    /**
     * @var IdName
     */
    public $endingLocation;

    /**
     * @var IdName
     */
    public $car;

    public function __construct(
        int $id,
        string $startDate,
        string $endDate,
        IdName $startingLocation,
        IdName $endingLocation,
        IdName $car
    ) {
        $this->id = $id;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->startingLocation = $startingLocation;
        $this->endingLocation = $endingLocation;
        $this->car = $car;
    }
}
