<?php

declare(strict_types=1);

namespace Francken\Domain;

use Assert\Assertion as Assert;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;
use Broadway\Serializer\SerializableInterface;

abstract class Identifier implements SerializableInterface
{
    use Serializable;

    protected $id;

    /**
     * @param string $committeeId
     */
    public function __construct(string $id)
    {
        Assert::uuid($id);

        $this->id = $id;
    }

    /**
     * Generates a new Identifier instance with a uuid
     */
    public static function generate() : Identifier
    {
        $generator = new Version4Generator();

        return new static($generator->generate());
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->id;
    }
}
