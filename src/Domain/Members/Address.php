<?php

namespace Francken\Domain\Members;

final class Address
{
    private $city;
    private $postalCode;
    private $street;
    private $streetNumber;

    public function __construct(string $city, string $postalCode, string $street, string $streetNumber)
    {
        $this->city = $city;
        $this->postalCode = $postalCode;
        $this->street = $street;
        $this->streetNumber = $streetNumber;
    }

    public function city() : string
    {
        return $this->city;
    }

    public function postalCode() : string
    {
        return $this->postalCode;
    }

    public function street() : string
    {
        return $this->street;
    }

    public function streetNumber() : string
    {
        return $this->streetNumber;
    }
}
