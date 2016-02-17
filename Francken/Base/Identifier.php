<?php

namespace Francken\Base;

use Assert\Assertion as Assert;

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
     * @return string
     */
    public function __toString()
    {
        return $this->id;
    }
}
