<?php

declare(strict_types=1);

namespace Francken\Association\Members;

final class Address
{
    private string $city;
    private string $postalCode;
    private string $address;
    private string $country;

    public function __construct(
        string $city,
        string $postalCode,
        string $address,
        string $country
    ) {
        $this->city = $city;
        $this->postalCode = $postalCode;
        $this->address = $address;
        $this->country = $country;
    }

    public function toString() : string
    {
        return $this->city . ' ' . $this->address . ' ' . $this->postalCode . ', ' . $this->country;
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

    public function country() : string
    {
        return $this->country;
    }
}
