<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

final class BoardName
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function fromNameOrYear(?string $name, BoardYear $year) : self
    {
        if ($name !== null && $name !== '') {
            return new static($name);
        }

        return new static($year->toString());
    }

    public function toString() : string
    {
        return $this->name;
    }
}
