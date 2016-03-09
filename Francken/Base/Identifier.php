<?php

namespace Francken\Base;

use Assert\Assertion as Assert;

use Broadway\UuidGenerator\Rfc4122\Version4Generator;

abstract class Identifier
{
    private $id;

    /**
     * @param string $committeeId
     */
    public function __construct($id)
    {
        Assert::string($id);
        Assert::uuid($id);

        $this->id = $id;
    }

    /**
     * Generates a new Identifier instance with a uuid
     */
    public static function generate()
    {
        $generator = new Version4Generator();

        return new static($generator->generate());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id;
    }
}
