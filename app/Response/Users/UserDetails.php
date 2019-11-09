<?php

namespace App\Response\Users;

/**
 * Defines user details response object.
 * Forces a specific structure on output responses.
 * Helps creating consistent responses.
 */
class UserDetails
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
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @var string
     */
    public $birthDate;

    /**
     * @var string
     */
    public $phoneNumber;

    /**
     * @var string
     */
    public $role;

    public function __construct(
        int $id,
        string $email,
        string $firstName,
        string $lastName,
        string $birthDate,
        string $phoneNumber,
        string $role
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthDate = $birthDate;
        $this->phoneNumber = $phoneNumber;
        $this->role = $role;
    }
}
