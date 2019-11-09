<?php

namespace App\Response\Locations;

/**
 * Defines user details response object.
 * Forces a specific structure on output responses.
 * Helps creating consistent responses.
 */
class LocationDetails
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $address;

    /**
     * @var double
     */
    public $latitude;

    /**
     * @var double
     */
    public $longitude;

    /**
     * @var double
     */
    public $phoneNumber;

    /**
     * @var int
     */
    public $totalCarsNumber;

    /**
     * @var int
     */
    public $availableCarsNumber;

    /**
     * @var int
     */
    public $rentedCarsNumber;

    public function __construct(
        int $id,
        string $email,
        string $name,
        string $address,
        float $latitude,
        float $longitude,
        string $phoneNumber,
        int $totalCarsNumber,
        int $availableCarsNumber,
        int $rentedCarsNumber
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
        $this->address = $address;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->phoneNumber = $phoneNumber;
        $this->totalCarsNumber = $totalCarsNumber;
        $this->availableCarsNumber = $availableCarsNumber;
        $this->rentedCarsNumber = $rentedCarsNumber;
    }
}
