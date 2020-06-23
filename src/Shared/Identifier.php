<?php

declare(strict_types=1);

namespace Francken\Shared;

use Assert\Assertion as Assert;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;

abstract class Identifier
{
    protected $id;

    public function __construct(string $id)
    {
        Assert::uuid($id);

        $this->id = $id;
    }

    public function __toString() : string
    {
        return $this->id;
    }

    /**
     * Generates a new Identifier instance with a uuid
     */
    public static function generate() : self
    {
        $generator = new Version4Generator();

        return new static($generator->generate());
    }
}
