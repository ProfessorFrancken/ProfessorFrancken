<?php

declare(strict_types=1);

namespace Francken\Domain\Activities;

use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;

final class Location implements SerializableInterface
{
    use Serializable;

    private $name;
    private $postalCode;
    private $streetName;
    private $streetNumber;

    private function __construct()
    {
    }

    public static function unspecified()
    {
        return new Location;
    }

    public static function fromNameAndAddress(string $name, string $postalCode = null, string $streetName = null, string $streetNumber = null)
    {
        $location = new Location;
        $location->name = $name;
        $location->postalCode = $postalCode;
        $location->streetName = $streetName;
        $location->streetNumber = $streetNumber;

        // district, city, region, country

        return $location;
    }

    public function name()
    {
        return $this->name;
    }

    public function postalCode()
    {
        return $this->postalCode;
    }

    public function streetName()
    {
        return $this->streetName;
    }

    public function streetNumber()
    {
        return $this->streetNumber;
    }
}
