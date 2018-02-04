<?php

declare(strict_types=1);

namespace Francken\Domain\Members;

use Broadway\Serializer\Serializable as SerializableInterface;
use Francken\Domain\Serializable;

final class Address implements SerializableInterface
{
    use Serializable;

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
