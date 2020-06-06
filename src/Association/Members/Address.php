<?php

declare(strict_types=1);

namespace Francken\Association\Members;

final class Address
{
    private $city;
    private $postalCode;
    private $address;

    public function __construct(
        string $city,
        string $postalCode,
        string $address
    ) {
        $this->city = $city;
        $this->postalCode = $postalCode;
        $this->address = $address;
    }

    public function toString() : string
    {
        return $this->city . ' ' . $this->address . ' ' . $this->postalCode;
    }

    public function city() : string
    {
        return $this->city;
    }

    public function postalCode() : string
    {
        return $this->postalCode;
    }

    public function address() : string
    {
        return $this->address;
    }
}
