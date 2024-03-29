<?php

declare(strict_types=1);

namespace Francken\Shared;

use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

abstract class Identifier
{
    protected string $id;

    final public function __construct(string $id)
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
     *
     * @return static
     */
    public static function generate()
    {
        return new static(Uuid::uuid4()->toString());
    }
}
