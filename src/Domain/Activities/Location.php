<?php

namespace Francken\Domain\Activities;

use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;

final class Location
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

    public static function fromNameAndAddress($name, $postalCode = '', $streetName = '', $streetNumber = '')
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

    protected static function deserializationCallbacks()
    {
        return [];
    }
}
